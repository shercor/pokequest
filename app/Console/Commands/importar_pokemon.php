<?php

namespace App\Console\Commands;
use Illuminate\Support\Facades\Http;
use App\Models\Pokemon;
use App\Models\Type;
use App\Models\Generation;
use Illuminate\Support\Facades\Log;

use Illuminate\Console\Command;

class importar_pokemon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:importar_pokemon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // vamos a importar los pokemon de la poke api
        $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=1025&offset=0');
        // dd($response->json()['results']);
        // dd(count($response->json()['results']));
        if ($response->successful()) {
            sleep(1); // espera 1 segundo entre llamadas
            $pkmn_list = [];
            $data = $response->json(); // convierte automáticamente a array
            foreach ($data['results'] as $i => $pokemon) {
                $retries = 0;
                $maxRetries = 5;
            
                RETRY:
                try {
                    $pokedex_number = $i + 1;
                    $pkmn = [];
            
                    // Obtener datos del Pokémon
                    $res = Http::get('https://pokeapi.co/api/v2/pokemon/' . $pokemon['name'])->json();
            
                    $pkmn['name'] = $res['name'];
                    $pkmn['sprite'] = $res['sprites']['front_default'];
                    $pkmn['height'] = $res['height'];
                    $pkmn['weight'] = $res['weight'];
                    $pkmn['base_experience'] = $res['base_experience'];
            
                    $types = [];
                    foreach ($res['types'] as $type) {
                        $types[] = $type['type']['name'];
                    }
            
                    $pkmn['primary_type'] = $types[0];
                    $pkmn['secondary_type'] = $types[1] ?? null;
            
                    // Obtener especie
                    $speciesUrl = $res['species']['url'];
                    $speciesResponse = Http::get($speciesUrl);
            
                    if ($speciesResponse->successful()) {
                        $genStr = $speciesResponse['generation']['name'];
                        $roman = str_replace('generation-', '', $genStr);
                        $pkmn['gen'] = $this->romanToInt($roman);
                        $pkmn['color'] = $speciesResponse['color']['name'];
            
                        // Cadena evolutiva
                        $evolutionChainUrl = $speciesResponse['evolution_chain']['url'];
                        $chainResponse = Http::get($evolutionChainUrl);
            
                        if ($chainResponse->successful()) {
                            $chain = $chainResponse['chain'];
                            $pkmn['evolution_stage'] = $this->getEvolutionStage($chain, $pkmn['name']);
                        }
                    }
            
                    // Insertar en la base de datos
                    $primaryType = Type::where('name', $pkmn['primary_type'])->first();
                    $secondaryType = $pkmn['secondary_type']
                        ? Type::where('name', $pkmn['secondary_type'])->first()
                        : null;
            
                    $generation = Generation::where('id', $pkmn['gen'])->first();
            
                    Pokemon::updateOrCreate(
                        ['name' => $pkmn['name']],
                        [
                            'sprite' => $pkmn['sprite'],
                            'height' => $pkmn['height'],
                            'weight' => $pkmn['weight'],
                            'primary_type_id' => $primaryType?->id,
                            'secondary_type_id' => $secondaryType?->id,
                            'generation_id' => $generation?->id,
                            'evolution_stage' => $pkmn['evolution_stage'],
                            'color' => $pkmn['color'],
                        ]
                    );
            
                    $this->line("✔ Pokémon importado: " . $pkmn['name']);
                    sleep(1); // prevenir rate limit
            
                } catch (\Exception $e) {
                    $retries++;
                    $this->error("❗ Error al importar {$pokemon['name']}: " . $e->getMessage());
                    if ($retries <= $maxRetries) {

                        $this->warn("❗ Error con {$pokemon['name']}. Reintentando en 30 segundos... (Intento {$retries}/{$maxRetries})");
                        sleep(15);
                        goto RETRY;
                    } else {
                        $this->error("💥 Falló {$pokemon['name']} tras {$maxRetries} intentos. Continuando...");
                        Log::error("Error con {$pokemon['name']}: " . $e->getMessage());
                        continue;
                    }
                }
            }
            dd('Esto es un dump');
        } else {
            $this->error("Error al consultar la API: " . $response->status());
            // Manejo de errores
            dd('Error al consultar la API');
        }
        
    }

    private function romanToInt($roman)
    {
        $romans = [
            'i' => 1,
            'ii' => 2,
            'iii' => 3,
            'iv' => 4,
            'v' => 5,
            'vi' => 6,
            'vii' => 7,
            'viii' => 8,
            'ix' => 9
        ];

        return $romans[strtolower($roman)] ?? null;
    }

    private function getEvolutionStage(array $chain, string $pokemonName, int $stage = 1)
    {
        // dd($chain);
        // Verifica si el Pokémon actual es el que buscamos
        dump($chain['species']['name']);
        dump($pokemonName);
        dump($stage);
        if (strtolower($chain['species']['name']) === strtolower($pokemonName)) {
            return $stage;
        }
        // dd($chain['evolves_to']);

        foreach ($chain['evolves_to'] as $next) {
            // dd($next, $pokemonName, $stage);
            $result = $this->getEvolutionStage($next, $pokemonName, $stage + 1);
            // dd($result);
            if ($result !== null) {
                // dd($result);
                return $result;
            }
        }
        // dd('No se encontró la evolución');
        return null;
    }
}
