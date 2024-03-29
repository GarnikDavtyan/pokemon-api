<?php

use App\Http\Controllers\AbilityController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\ShapeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('pokemons', PokemonController::class);

Route::apiResource('shapes', ShapeController::class);

Route::apiResource('locations', LocationController::class);

Route::apiResource('abilities', AbilityController::class);

Route::get('images/{type}/{id}', [ImageController::class, 'getImage'])->name('images.get');