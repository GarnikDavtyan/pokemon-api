<?php

namespace App\Services;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Database\Eloquent\Collection;

class LocationService
{
    public function list(): Collection
    {
        $locations = Location::all();

        return $locations;
    }

    public function store(StoreLocationRequest $request): Location
    {
        $shape = Location::create(['name' => $request->name]);

        return $shape;
    }
    
    public function update(UpdateLocationRequest $request, Location $location): Location
    {
        $location->update(['name' => $request->name]);

        return $location;
    }

    public function delete(Location $location): void
    {
        $location->delete();
    }
}