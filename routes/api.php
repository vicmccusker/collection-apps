<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/pokemon-cards', [\App\Http\Controllers\PokemonCardController::class, 'all']);
Route::get('/pokemon-cards/{id}', [\App\Http\Controllers\PokemonCardController::class, 'find']);
Route::post('/pokemon-cards', [\App\Http\Controllers\PokemonCardController::class, 'create']);
Route::put('/pokemon-cards/{id}', [\App\Http\Controllers\PokemonCardController::class, 'update']);
Route::delete('/pokemon-cards/{id}', [\App\Http\Controllers\PokemonCardController::class, 'delete']);
