<?php

namespace App\Http\Controllers;
use App\Models\Pokemon;
use Illuminate\Http\Request;

class PokemonsController extends Controller
{
    public function index()
    {
        $pokemons = Pokemon::with(['primaryType', 'secondaryType', 'generation'])
            ->orderBy('id')
            ->paginate(25); // puedes ajustar la cantidad por página

        return view('pokemons.index', compact('pokemons'));
    }

    public function pokemonOfTheDay()
    {
        // Buscar un Pokemon aleatorio
        $pokedex_number = rand(1, 1025);
        $pokemon = Pokemon::where('id', $pokedex_number)->first();
        // Mostrar el nombre con CamelCase
        // Traer todos los pokemones para el select, que vengan con los datos de la tabla types y generations

        $pokemon_list = Pokemon::with(['primaryType', 'secondaryType', 'generation'])
            ->orderBy('id')
            ->get();
        $pokemon = Pokemon::inRandomOrder()->first();
        return view('pokemons.pokemon_of_the_day', compact('pokemon', 'pokemon_list'));
    }

    public function show(Request $request)
    {
        $pokemon = Pokemon::where('name', strtolower($request->name))->firstOrFail();
        return view('pokemons.show', compact('pokemon'));
    }
}
