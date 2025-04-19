<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pokemons', [PokemonsController::class, 'index'])->name('pokemons.index');

Route::get('/pokemon-of-the-day', [PokemonsController::class, 'pokemonOfTheDay'])->name('pokemons.pokemon_of_the_day');

Route::get('/pokemons/show', [PokemonController::class, 'show'])->name('pokemons.show');
