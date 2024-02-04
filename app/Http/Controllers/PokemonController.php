<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Http\Requests\StorePokemonRequest;
use App\Http\Requests\UpdatePokemonRequest;
use App\Services\PokemonService;
use Exception;
use Illuminate\Http\Request;

class PokemonController extends Controller
{
    private $pokemonService;

    public function __construct(PokemonService $service)
    {
        $this->pokemonService = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pokemons = $this->pokemonService->list($request);

        return $this->successResponse($pokemons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePokemonRequest $request)
    {
        try {
            $pokemon = $this->pokemonService->store($request);

            return $this->successResponse($pokemon, 'Pokemon created successfully', 201);
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pokemon $pokemon)
    {
        $pokemon = $this->pokemonService->read($pokemon);

        return $this->successResponse($pokemon);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePokemonRequest $request, Pokemon $pokemon)
    {
        try {
            $pokemon = $this->pokemonService->update($request, $pokemon);

            return $this->successResponse($pokemon, 'Pokemon updated successfully');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pokemon $pokemon)
    {
        $this->pokemonService->delete($pokemon);

        return $this->successResponse(null, 'Pokemon deleted successfully');
    }
}
