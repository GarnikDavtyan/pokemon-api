<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://pokeapi.co/api/v2/location');
        $locations = $response->json()['results'];

        foreach ($locations as $location) {
            Location::create([
                'name' => $location['name']
            ]);
        }


    }
}
