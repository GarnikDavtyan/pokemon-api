<?php

namespace App\Services;

use App\Helpers\PokemonsHelper;
use App\Http\Requests\StorePokemonRequest;
use App\Http\Requests\UpdatePokemonRequest;
use App\Models\Location;
use App\Models\Pokemon;
use Exception;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PokemonService 
{
    public function list(Request $request): LengthAwarePaginator
    {
        $pokemonsQuery = Pokemon::query();

        $filterLocation = $request->location;
        $filterRegion = $request->region;
        $order = $request->order;

        if($filterRegion) {
            $pokemonsQuery->where('region', $filterRegion);
        } 
        
        if ($filterLocation) {
            $pokemonsQuery->where('location_id', $filterLocation);
        }

        if ($order === 'location' && !$filterLocation) {
            $pokemonsQuery->join('locations', 'pokemons.location_id', '=', 'locations.id')
                ->orderBy('locations.name')
                ->select('pokemons.*');
        }
        
        $pokemons = $pokemonsQuery->with([
            'shape', 
            'abilities', 
            'location'
            ])->paginate(10)->appends([
                'location' => $filterLocation,
                'region' => $filterRegion,
                'order' => $order
            ]);

        return $pokemons;
    }

    public function read(Pokemon $pokemon): Pokemon
    {
        return $pokemon->load([
            'shape', 
            'abilities', 
            'location'
        ]);
    }

    public function store(StorePokemonRequest $request): Pokemon
    {
        try {
            DB::beginTransaction();

            $location = Location::findOrFail($request->location_id)->name;

            $faker = Factory::create();
            do {
                $serialNumber = $faker->unique()->randomNumber(6);
            } while (Pokemon::where('serial_number', $serialNumber)->exists());

            $pokemon = Pokemon::create([
                'name' => $request->name,
                'serial_number' => $serialNumber,
                'shape_id' =>  $request->shape_id,
                'location_id' => $request->location_id,
                'region' => PokemonsHelper::getRegion($location),
            ]);

            if ($request->hasFile('image')) {
                $image = Storage::putFile('images/pokemon', $request->file('image'));
                $pokemon->images()->create(compact('image'));
            }

            $abilities = $request->abilities;
            $pokemon->abilities()->attach($abilities);

            DB::commit();

            return $pokemon->load([
                'shape', 
                'abilities', 
                'location'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Storage::delete($image);

            throw $e;
        }
    }
    
    public function update(UpdatePokemonRequest $request, Pokemon $pokemon): Pokemon
    {
        try {
            DB::beginTransaction();

            $location = Location::findOrFail($request->location_id)->name;

            $pokemon->update([
                'name' => $request->name,
                'shape_id' =>  $request->shape_id,
                'location_id' => $request->location_id,
                'region' => PokemonsHelper::getRegion($location)
            ]);

            $abilities = $request->abilities;
            $pokemon->abilities()->sync($abilities);

            if($request->hasFile('image')) {
                if($pokemon->images()->exists()) {
                    Storage::delete($pokemon->images->first()->image);
                    $pokemon->images()->delete();
                }

                $image = Storage::putFile('images/pokemon', $request->file('image'));
                $pokemon->images()->create(compact('image'));
            }

            DB::commit();
            
            return $pokemon->load([
                'shape', 
                'abilities', 
                'location'
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function delete(Pokemon $pokemon): void
    {
        try {
            DB::beginTransaction();

            if($pokemon->images()->exists()) {
                Storage::delete($pokemon->images->first()->image);
                $pokemon->images()->delete();
            }
            
            $pokemon->abilities()->detach();
            $pokemon->delete();
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            
            throw $e;
        }
    }
}