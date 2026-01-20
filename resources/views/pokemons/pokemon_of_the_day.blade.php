@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Pokémon del Día</h1>

    <!-- Mostrar el Pokémon aleatorio -->
    <div id="pokemon-card" class="d-none mb-4 p-2 shadow-sm  d-flex align-items-center gap-5 justify-content-around border rounded" style="width:">
        <div class="mr-4" style="text-align: center;">
            <h3 class="card-title">🌟 {{ ucfirst($pokemon->name) }}</h3>
            @if ($pokemon->sprite)
                <img src="{{ $pokemon->sprite }}" alt="{{ $pokemon->name }}" class="img-fluid" style="max-width: 120px;">
            @endif

        </div>

        <ul class="mt-3 list-unstyled row">
            <li class="col-6 d-flex gap-2" ><strong>Tipo primario:</strong> <div id="pokemon_primary_type">{{ $pokemon->primaryType?->name }}</div></li>
            <li class="col-6 d-flex gap-2" ><strong>Tipo secundario:</strong> <div id="pokemon_secondary_type">{{ $pokemon->secondaryType ? $pokemon->secondaryType->name : 'Ninguno' }}</div></li>
            <li class="col-6 d-flex gap-2" ><strong>Generación:</strong> <div id="pokemon_region">{{ $pokemon->generation?->name }}</div></li>
            <li class="col-6 d-flex gap-2" ><strong>Color:</strong> <div id="pokemon_color">{{ ucfirst($pokemon->color) }}</div></li>
            <li class="col-6 d-flex gap-2" ><strong>Peso:</strong> <div id="pokemon_weight">{{ $pokemon->weight }}</div></li>
            <li class="col-6 d-flex gap-2" ><strong>Altura:</strong> <div id="pokemon_height">{{ $pokemon->height }}</div></li>
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
            
            <div class="text-center">Tipo primario</div>
            <div class="text-center">Tipo secundario</div>
            <div class="text-center">Región</div>
            <div class="text-center">Color</div>
            <div class="text-center">Altura</div>
            <div class="text-center">Peso</div>
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

img.disabled {
  filter: grayscale(100%); /* blanco y negro */
  opacity: 0.5;            /* más apagada */
  pointer-events: none;    /* no se puede clickear */
}

div.disabled{
  opacity: 0.6;           /* lo hace más gris */
  pointer-events: none;    /* evita clics o interacción */
  cursor: not-allowed;     /* muestra el cursor de prohibido */
  filter: grayscale(80%);  /* opcional: más efecto apagado */
}

.field-label{
    margin-top: auto;     /* 🔑 empuja la barra al fondo */
    background-color: black;
    color: white;
    font-size: 16px;
    text-align: center;
    padding: 6px 0;
    width: 100%;
}


</style>

<script>
    
    const pokemonList = @json($pokemon_list); // Json con listado de los Pokemon
    const input = document.getElementById('pokemon-search'); // Input del buscador de Pokemon
    const results = document.getElementById('autocomplete-results'); // Contenedor de resultados de autocompletado
    const pokemonListContainer = document.getElementById('pokemon-list-container'); // Contenedor de la lista de Pokemon que se han escogido
    const assetBase = "{{ asset('types') }}"; // Base de assets para los tipos de Pokemon
    const assetRegionBase = "{{ asset('regions') }}"; // Base de assets para las regiones de Pokemon

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

    const clue_colors = {
        success : '#33EF75',
        warning : '#ffc107',
        error   : '#dc3545',
    }


    const pokemon_data = {
            primary_type: listaTiposPokemonEspanol[document.getElementById('pokemon_primary_type').innerText],
            secondary_type: ( listaTiposPokemonEspanol[document.getElementById('pokemon_secondary_type').innerText] ? listaTiposPokemonEspanol[document.getElementById('pokemon_secondary_type').innerText] :  'Ninguno'),
            region: document.getElementById('pokemon_region').innerText,
            color: document.getElementById('pokemon_color').innerText,
            height: (document.getElementById('pokemon_height').innerText / 10) + ' m',
            weight: (document.getElementById('pokemon_weight').innerText / 10) + ' kg',
        }

    document.addEventListener('DOMContentLoaded', () => {
        const tipoDiv = document.getElementById('pokemon_primary_type');
        const tipoIngles = tipoDiv.textContent.trim().toLowerCase();
        const tipoTraducido = listaTiposPokemonEspanol[tipoIngles] || tipoIngles;
        tipoDiv.textContent = tipoTraducido;

    });

    

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
                
                // Limpiar input y resultados
                results.innerHTML = '';
                input.value = ''

                const newLi = document.createElement('div');
                newLi.className = "pokemon-row mb-1 py-2 d-flex justify-content-around align-items-center";

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
                    crearDivInvisible(listaTiposPokemonEspanol[p.primary_type.name], 'primary_type'),
                    crearDivInvisible(p.secondary_type ? listaTiposPokemonEspanol[p.secondary_type.name] : 'Ninguno', 'secondary_type'),
                    crearDivInvisible(p.generation.name, 'region'),
                    crearDivInvisible(capitalize(p.color), 'color'),
                    crearDivInvisible((p.height / 10) + ' m' , 'height'),
                    crearDivInvisible((p.weight / 10) + ' kg', 'weight'),
                ];

                // divs.forEach(div => newLi.appendChild(div));
                // pokemonListContainer.appendChild(newLi);

                divs.forEach(div => newLi.appendChild(div));
                // Si hay una fila de encabezado, insertar después de ella
                const header = document.getElementById('pokemon-list-header');
                if (header && header.parentNode) {
                    header.parentNode.insertBefore(newLi, header.nextSibling);
                } else {
                    // Si no hay header, insertar al principio
                    pokemonListContainer.insertBefore(newLi, pokemonListContainer.firstChild);
                }

                // cambiar display de pokemonListContainer a block
                pokemonListContainer.style.display = 'block';

                // Mostrar uno por uno cada 1 segundo
                const esperar = ms => new Promise(resolve => setTimeout(resolve, ms));

                //número con el tamaño de divs
                const numDivs = divs.length;
                contador = 0;

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
                };
            });
            results.appendChild(li);
        });
    });

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function hexToRgb(hex) {
        hex = hex.replace(/^#/, '');

        // Convierte los valores
        const bigint = parseInt(hex, 16);
        const r = (bigint >> 16) & 255;
        const g = (bigint >> 8) & 255;
        const b = bigint & 255;

        return `rgb(${r}, ${g}, ${b})`;
    }

    function crearDivInvisible(contenido, tipo) {
        console.log('El tipo es:', pokemon_data[tipo], 'el tipo solo es: ', tipo ,' y el contenido es:', contenido);
        const boxDiv = document.createElement('div');
        boxDiv.textContent = contenido;
        boxDiv.style.opacity = '0';
        boxDiv.style.visibility = 'hidden';
        boxDiv.style.transition = 'opacity 0.5s ease';

        // Se verifica si el contenido coincide con el del Pokémon del día
        if (pokemon_data[tipo] == contenido){
            console.log('El tipo es:', pokemon_data[tipo], 'y el contenido es:', contenido);
            boxDiv.style.backgroundColor = clue_colors.success;
        } else {
            // Solo si es primary_type o secondary_type, poner color de advertencia
            if(tipo == 'primary_type' || tipo == 'secondary_type'){
                // Verificar si en este caso, coincide al menos con el otro tipo
                const otroTipo = (tipo == 'primary_type') ? 'secondary_type' : 'primary_type';
                if (pokemon_data[otroTipo] == contenido){
                    console.log('El otro tipo coincide para:', otroTipo, 'con contenido:', contenido);
                    boxDiv.style.backgroundColor = clue_colors.warning;
                } else {
                    // boxDiv.style.backgroundColor = clue_colors.error;
                }
                boxDiv.classList.add('disabled');
            }
        }

        // Si es tipo primario o secundario, añadir imagen del tipo
        if(tipo == 'primary_type' || tipo == 'secondary_type'){
            var clave = Object.keys(listaTiposPokemonEspanol).find(
                key => listaTiposPokemonEspanol[key] === contenido
            );
            console.log('El tipo EEEES:', contenido);
            boxDiv.style.overflow = 'hidden';
            boxDiv.style.display = 'flex';
            boxDiv.style.flexDirection = 'column';
            console.log('La clave es:', clave);
            if(clave !== undefined){
                console.log('Se entró al div:', contenido);
                boxDiv.innerHTML = `
                <img src="${assetBase}/${clave}.svg" alt="Tipo ${clave}" class="${clave} my-auto" style="max-width: 66%; max-height: 66%; padding: 15px; border-radius: 50%;">
                <div style="background-color: black; color: white; margin-top: auto; font-size: 18px; width: 100%; height: 21% !important;">${contenido}</div>
            `;
            }
            

        }

        if (tipo == 'region'){
        boxDiv.style.overflow = 'hidden';
            boxDiv.style.display = 'flex';
            boxDiv.style.flexDirection = 'column';
            boxDiv.innerHTML = `
                <img src="${assetRegionBase}/${contenido}.jpg" alt="Tipo ${clave}" class="${clave} my-auto" style="width: 100%; height: 79% !important;">
                <div style="background-color: black; color: white; margin-top: auto; font-size: 18px; width: 100%; height: 21% !important;">${contenido}</div>
            `;
        }

        if (tipo == 'height' || tipo == 'weight'){
            // Detectar si el pokemon es mayor o menor que el del día
            const valorContenido = parseFloat(contenido);
            const valorPokemonDia = parseFloat(pokemon_data[tipo]);
            console.log('Comparando valores para Pokemon del día -> ', tipo, ':', valorContenido, 'y Pokemon seleccionado -> ', valorPokemonDia);
            if (valorContenido < valorPokemonDia) {
                console.log('El valor es más pequeño:', valorContenido, ' es menor que ', valorPokemonDia);
                // Más pequeño, añadir una flecha hacia arriba al lado del valor
                boxDiv.innerHTML = `
                    <div style="position:relative; display: flex; align-items: center; justify-content: center; gap: 5px;">
                        ${contenido}
                        <span style="color: ${clue_colors.error}; font-size: 27px; position:absolute; bottom: 30px;">&#8593;</span>
                    </div>
                `;
            } else if (valorContenido > valorPokemonDia) {
                console.log('El valor es más grande:', valorContenido, ' es mayor que ', valorPokemonDia);
                // Más grande, añadir una flecha hacia abajo al lado del valor
                boxDiv.innerHTML = `
                    <div style="position:relative; display: flex; align-items: center; justify-content: center; gap: 5px;">
                        ${contenido}
                        <span style="color: ${clue_colors.error}; font-size: 27px; position:absolute; top: 30px;">&#8595;</span>
                    </div>
                `;
            }

        }
        return boxDiv;
    };
</script>



@endsection


