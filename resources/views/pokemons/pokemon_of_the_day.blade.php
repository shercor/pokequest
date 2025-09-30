@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Pokémon del Día</h1>

    <!-- Mostrar el Pokémon aleatorio -->
    <div class="mb-4 p-2 shadow-sm  d-flex align-items-center gap-5 justify-content-around border rounded" style="width:">
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
        <div class="mb-4 d-flex justify-content-start">
            <label for="pokemon-name" class="form-label mb-0" style="font-size:24px;">🔍 Escribe el nombre de un Pokémon:</label>
            <div class="autocomplete-container d-flex justify-content-center mx-3" style="position: relative; width: 400px;">
                <input type="text" id="pokemon-search" class="form-control" placeholder="Buscar Pokémon..." style="border-radius: 21px; max-width: 500px !important;">
                <ul id="autocomplete-results" class="autocomplete-list"></ul>
            </div>

        </div>
    </form>
    

    <!-- Encabezado tabla -->
    <div id="pokemon-list-container" class="mb-4" style="display: none;">
        <div id="pokemon-list-header" class="pokemon-label-row table-header d-flex justify-content-around align-items-center mb-3">
            <div class="text-center">Pokémon</div>
            <div class="text-center">Peso</div>
            <div class="text-center">Altura</div>
            <div class="text-center">Tipo primario</div>
            <div class="text-center">Tipo secundario</div>
            <div class="text-center">Región</div>
            <div class="text-center">Color</div>
        </div>
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
.table-header div{
    border-bottom: solid black 2px;
}
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
    font-size: 22px;
    color: #333;
    text-align: center;
    width: 150px;
    height: 125px;
    border: solid black 2px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;

}
.pokemon-label-row > div{
    font-size: 22px;
    color: #333;
    text-align: center;
    width: 150px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;

}

.bug {
    background: #92BC2C;
    box-shadow: 0 0 20px #92BC2C;
}

.dark {
    background: #595761;
    box-shadow: 0 0 20px #595761;
}

.dragon {
    background: #0C69C8;
    box-shadow: 0 0 20px #0C69C8;
}

.electric {
    background: #F2D94E;
    box-shadow: 0 0 20px #F2D94E;
}

.fire {
    background: #FBA54C;
    box-shadow: 0 0 20px #FBA54C;
}

.fairy {
    background: #EE90E6;
    box-shadow: 0 0 20px #EE90E6;
}

.fighting {
    background: #D3425F;
    box-shadow: 0 0 20px #D3425F;
}

.flying {
    background: #A1BBEC;
    box-shadow: 0 0 20px #A1BBEC;
}

.ghost {
    background: #5F6DBC;
    box-shadow: 0 0 20px #5F6DBC;
}

.grass {
    background: #5FBD58;
    box-shadow: 0 0 20px #5FBD58;
}

.ground {
    background: #DA7C4D;
    box-shadow: 0 0 20px #DA7C4D;
}

.ice {
    background: #75D0C1;
    box-shadow: 0 0 20px #75D0C1;
}

.normal {
    background: #A0A29F;
    box-shadow: 0 0 20px #A0A29F;
}

.poison {
    background: #B763CF;
    box-shadow: 0 0 20px #B763CF;
}

.psychic {
    background: #FA8581;
    box-shadow: 0 0 20px #FA8581;
}

.rock {
    background: #C9BB8A;
    box-shadow: 0 0 20px #C9BB8A;
}

.steel {
    background: #5695A3;
    box-shadow: 0 0 20px #5695A3;
}

.water {
    background: #539DDF;
    box-shadow: 0 0 20px #539DDF;
}

</style>

<script>
    const pokemonList = @json($pokemon_list);

    const input = document.getElementById('pokemon-search');
    const results = document.getElementById('autocomplete-results');
    const pokemonListContainer = document.getElementById('pokemon-list-container');

    const assetBase = "{{ asset('types') }}";


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
                newLi.className = "pokemon-row mb-1 py-2 d-flex justify-content-around align-items-center";

                // Función para crear un div invisible
                const crearDivInvisible = (contenido, tipo) => {
                    console.log('El tipo es:', pokemon_data[tipo], 'el tipo solo es: ', tipo ,' y el contenido es:', contenido);
                    const div = document.createElement('div');
                    div.textContent = contenido;
                    div.style.opacity = '0';
                    div.style.visibility = 'hidden';
                    div.style.transition = 'opacity 0.5s ease';
                    // div.innerHTML = '<img src="{{ asset('types/normal.svg') }}" alt="Normal Type" style="max-width: 100%; max-height: 100%;">';
                    if (pokemon_data[tipo] == contenido){
                        console.log('El tipo es:', pokemon_data[tipo], 'y el contenido es:', contenido);
                        div.style.backgroundColor = clue_colors.success;
                    } else {
                        console.log('El tipo es:', pokemon_data[tipo], 'y el contenido es:', contenido);
                        div.style.backgroundColor = clue_colors.error;
                    }

                    if(tipo == 'primary_type' || tipo == 'secondary_type'){
                        // const img = document.createElement('img');
                        // // pasar a minúsculas y quitar acentos
                        // let tipo_sin_acentos = contenido.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
                        // if (tipo_sin_acentos == 'ninguno'){
                        //     tipo_sin_acentos = 'normal';
                        // }
                        // img.src = `/types/${tipo_sin_acentos}.svg`;
                        // img.alt = `${contenido} Type`;
                        // img.style.maxWidth = '100%';
                        // img.style.maxHeight = '100%';
                        // div.innerHTML = '';
                        // div.appendChild(img);
                        var clave = Object.keys(listaTiposPokemonEspanol).find(
                            key => listaTiposPokemonEspanol[key] === contenido
                        );
                        console.log('El tipo EEEES:', contenido);
                        div.innerHTML = `<img src="${assetBase}/${clave}.svg" alt="Tipo ${clave}" class="${clave}" style="max-width: 66%; max-height: 66%; padding: 15px; border-radius: 50%;">`;

                    }
                    return div;
                };

                // Imagen + nombre
                const nameDiv = document.createElement('div');
                nameDiv.style.display = 'block';
                nameDiv.style.backgroundColor = 'white';
                nameDiv.style.overflow = 'hidden';
                nameDiv.style.fontSize = '18px';

                const img = document.createElement('img');
                img.src = p.sprite;
                img.alt = p.name;

                const name = document.createElement('div');
                name.textContent = capitalize(p.name);
                name.style.backgroundColor = 'black';
                name.style.color = 'white';

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

                // cambiar display de pokemonListContainer a block
                pokemonListContainer.style.display = 'block';

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


