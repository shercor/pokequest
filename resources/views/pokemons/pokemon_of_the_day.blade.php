@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Pokémon del Día</h1>

    {{-- Mostrar el Pokémon aleatorio --}}
    <div class="mb-4 p-2 shadow-sm  d-flex align-items-center gap-5 justify-content-around" style="width:">
        <div class="mr-4" style="text-align: center;">
            <h3 class="card-title">🌟 {{ ucfirst($pokemon->name) }}</h3>
            @if ($pokemon->sprite)
                <img src="{{ $pokemon->sprite }}" alt="{{ $pokemon->name }}" class="img-fluid" style="max-width: 120px;">
            @endif

        </div>

        <ul class="mt-3 list-unstyled row">
            <li class="col-6 d-flex gap-2" ><strong>Altura:</strong> <div id="pokemon_height">{{ $pokemon->height }}</div></li>
            <li class="col-6 d-flex gap-2" ><strong>Peso:</strong> <div id="pokemon_weight">{{ $pokemon->weight }}</div></li>
            <li class="col-6 d-flex gap-2" ><strong>Tipo primario:</strong> <div id="pokemon_primary_type">{{ $pokemon->primaryType?->name }}</div></li>
            <li class="col-6 d-flex gap-2" ><strong>Tipo secundario:</strong> <div id="pokemon_secondary_type">{{ $pokemon->secondaryType ? $pokemon->secondaryType->name : 'Ninguno' }}</div></li>
            <li class="col-6 d-flex gap-2" ><strong>Generación:</strong> <div id="pokemon_region">{{ $pokemon->generation?->name }}</div></li>
            <li class="col-6 d-flex gap-2" ><strong>Color:</strong> <div id="pokemon_color">{{ ucfirst($pokemon->color) }}</div></li>
        </ul>
    </div>



    {{-- Input con datalist --}}
    <form method="GET" action="{{ route('pokemons.show') }}">
        <div class="mb-4">
            <label for="pokemon-name" class="form-label mx-auto">🔍 Escribe el nombre de un Pokémon:</label>
            <div class="autocomplete-container d-flex justify-content-center" style="position: relative;">
                <input type="text" id="pokemon-search" class="form-control" placeholder="Buscar Pokémon..." style="border-radius: 21px; max-width: 500px !important;">
                <ul id="autocomplete-results" class="autocomplete-list"></ul>
            </div>

        </div>
    </form>

    <div id="pokemon-list-container" class="mb-4">
    </div>

    <!-- Modal de Pokémon adivinado -->
    <div class="modal fade" id="adivinado" tabindex="-1" role="dialog" aria-labelledby="adivinadoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adivinadoLabel">Pokémon adivinado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="text-align: center;">
                ¡Adivinaste el Pokémon! 🎉
                <div class="d-flex justify-content-center align-items-center flex-column mt-3">
                    <img src="{{ $pokemon->sprite }}" alt="{{ $pokemon->name }}" class="img-fluid" style="max-width: 120px;">
                    <h3 class="card-title mt-3">{{ ucfirst($pokemon->name) }}</h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>

</div>

<style>
.autocomplete-list {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: white;
    /* border: 2px solid #ccc; */
    border-radius: 8px;
    max-height: 300px;
    overflow-y: auto;
    z-index: 1000;
    padding: 0;
    margin: 0;
    list-style: none;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.autocomplete-list li {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
    font-family: 'Press Start 2P', sans-serif; /* Si usas esa fuente */
}

.autocomplete-list li img {
    width: 40px;
    height: 40px;
    margin-right: 12px;
    border: 2px solid #000;
    border-radius: 8px;
    background-color: #fff;
}

.autocomplete-list li:hover {
    background-color: #f0f0f0;
}

.pokemon-row > div{
    font-family: 'Press Start 2P', sans-serif;
    font-size: 14px;
    color: #333;
    text-align: center;
    width: 125px;
    height: 125px;
    border: solid black 2px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;

}
</style>

<script>
    const pokemonList = @json($pokemon_list);

    const input = document.getElementById('pokemon-search');
    const results = document.getElementById('autocomplete-results');
    const pokemonListContainer = document.getElementById('pokemon-list-container');

    const listaTiposPokemonEspanol = {
        normal: 'Normal',
        fire: 'Fuego',
        water: 'Agua',
        electric: 'Eléctrico',
        grass: 'Planta',
        ice: 'Hielo',
        fighting: 'Lucha',
        poison: 'Veneno',
        ground: 'Tierra',
        flying: 'Volador',
        psychic: 'Psíquico',
        bug: 'Bicho',
        rock: 'Roca',
        ghost: 'Fantasma',
        dragon: 'Dragón',
        dark: 'Siniestro',
        steel: 'Acero',
        fairy: 'Hada'
    }

    console.log('El tipo secondario es:', !listaTiposPokemonEspanol[document.getElementById('pokemon_secondary_type').innerText]);
    const pokemon_data = {
            height: document.getElementById('pokemon_height').innerText,
            weight: document.getElementById('pokemon_weight').innerText,
            primary_type: listaTiposPokemonEspanol[document.getElementById('pokemon_primary_type').innerText],
            secondary_type: ( listaTiposPokemonEspanol[document.getElementById('pokemon_secondary_type').innerText] ? listaTiposPokemonEspanol[document.getElementById('pokemon_secondary_type').innerText] :  'Ninguno'),
            region: document.getElementById('pokemon_region').innerText,
            color: document.getElementById('pokemon_color').innerText,
        }
    console.log('La data de Pokémon es:', pokemon_data);

    document.addEventListener('DOMContentLoaded', () => {
        const tipoDiv = document.getElementById('pokemon_primary_type');
        const tipoIngles = tipoDiv.textContent.trim().toLowerCase();
        const tipoTraducido = listaTiposPokemonEspanol[tipoIngles] || tipoIngles;
        tipoDiv.textContent = tipoTraducido;

    });

    
    const clue_colors = {
        success : '#28a745',
        error: '#dc3545',
    }

    input.addEventListener('input', function () {
        const term = this.value.toLowerCase();
        results.innerHTML = '';

        if (term.length === 0) return;

        const matches = pokemonList.filter(p => p.name.toLowerCase().includes(term)).slice(0, 40);

        matches.forEach(p => {
            const li = document.createElement('li');
            li.innerHTML = `
                <img src="${p.sprite}" alt="${p.name}">
                ${capitalize(p.name)}
            `;

            li.addEventListener('click', async () => {
                console.log(p);

                
                // Limpiar input y resultados
                results.innerHTML = '';
                input.value = ''

                const newLi = document.createElement('div');
                newLi.className = "pokemon-row mb-3 p-4 d-flex justify-content-between align-items-center";

                // Función para crear un div invisible
                const crearDivInvisible = (contenido, tipo) => {
                    console.log('El tipo es:', pokemon_data[tipo], 'el tipo solo es: ', tipo ,' y el contenido es:', contenido);
                    const div = document.createElement('div');
                    div.textContent = contenido;
                    div.style.opacity = '0';
                    div.style.visibility = 'hidden';
                    div.style.transition = 'opacity 0.5s ease';
                    if (pokemon_data[tipo] == contenido){
                        console.log('El tipo es:', pokemon_data[tipo], 'y el contenido es:', contenido);
                        div.style.backgroundColor = clue_colors.success;
                    } else {
                        console.log('El tipo es:', pokemon_data[tipo], 'y el contenido es:', contenido);
                        div.style.backgroundColor = clue_colors.error;
                    }
                    return div;
                };

                // Imagen + nombre
                const nameDiv = document.createElement('div');
                nameDiv.style.display = 'block';

                const img = document.createElement('img');
                img.src = p.sprite;
                img.alt = p.name;

                const name = document.createElement('div');
                name.textContent = capitalize(p.name);

                nameDiv.appendChild(img);
                nameDiv.appendChild(name);
                newLi.appendChild(nameDiv);

                console.log('El tipo primario es:', listaTiposPokemonEspanol[p.primary_type.name]);

                // Resto de los atributos, invisibles por ahora
                const divs = [
                    crearDivInvisible(p.height , 'height'),
                    crearDivInvisible(p.weight, 'weight'),
                    crearDivInvisible(listaTiposPokemonEspanol[p.primary_type.name], 'primary_type'),
                    crearDivInvisible(p.secondary_type ? listaTiposPokemonEspanol[p.secondary_type.name] : 'Ninguno', 'secondary_type'),
                    crearDivInvisible(p.generation.name, 'region'),
                    crearDivInvisible(capitalize(p.color), 'color'),
                ];

                divs.forEach(div => newLi.appendChild(div));
                pokemonListContainer.appendChild(newLi);

                // Mostrar uno por uno cada 1 segundo
                const esperar = ms => new Promise(resolve => setTimeout(resolve, ms));

                //número con el tamaño de divs
                const numDivs = divs.length;
                contador = 0;
                function hexToRgb(hex) {
                    // Remueve el "#" si existe
                    hex = hex.replace(/^#/, '');

                    // Convierte los valores
                    const bigint = parseInt(hex, 16);
                    const r = (bigint >> 16) & 255;
                    const g = (bigint >> 8) & 255;
                    const b = bigint & 255;

                    return `rgb(${r}, ${g}, ${b})`;
                }
                const successRgb = hexToRgb(clue_colors.success);

                for (const div of divs) {
                    await esperar(500);
                    div.style.visibility = 'visible';
                    div.style.opacity = '1';
                    // si el color del div es el de success, sumar 1 al contador
                    console.log('El color del div es:', div.style.backgroundColor, 'y el color de éxito es:', clue_colors.success);
                    if (div.style.backgroundColor == successRgb) {
                        contador++;
                    }
                }
                console.log('La cantidad de aciertos es:', contador, 'y el número de divs es:', numDivs);
                if (contador === numDivs) {
                    const modal = new bootstrap.Modal(document.getElementById('adivinado'));
                    modal.show();
                }
;
            });

            results.appendChild(li);
        });

    });

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
</script>



@endsection


