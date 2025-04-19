@extends('layouts.app') {{-- o usa layout personalizado si tienes uno --}}

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Pokémon</h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Sprite</th>
                <th>Altura</th>
                <th>Peso</th>
                <th>Experiencia base</th>
                <th>Tipo primario</th>
                <th>Tipo secundario</th>
                <th>Generación</th>
                <th>Fase Evolutiva</th>
                <th>Color</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pokemons as $pokemon)
            <tr>
                <td>{{ $pokemon->id }}</td>
                <td>{{ ucfirst($pokemon->name) }}</td>
                <td>
                    @if ($pokemon->sprite)
                        <img src="{{ $pokemon->sprite }}" alt="{{ $pokemon->name }}" style="width: 50px;">
                    @endif
                </td>
                <td>{{ $pokemon->height }}</td>
                <td>{{ $pokemon->weight }}</td>
                <td>{{ $pokemon->base_experience }}</td>
                <td>{{ $pokemon->primaryType?->name }}</td>
                <td>{{ $pokemon->secondaryType?->name ?? '—' }}</td>
                <td>{{ $pokemon->generation?->number }}</td>
                <td>{{ $pokemon->evolution_stage }}</td>
                <td>{{ ucfirst($pokemon->color) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="d-flex justify-content-center">
        {{ $pokemons->links() }}
    </div>
</div>
@endsection
