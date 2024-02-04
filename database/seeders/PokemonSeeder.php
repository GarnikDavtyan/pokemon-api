<?php

namespace Database\Seeders;

use App\Helpers\PokemonsHelper;
use App\Models\Ability;
use App\Models\Location;
use App\Models\Pokemon;
use App\Models\Shape;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PokemonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        $response = Http::get('https://pokeapi.co/api/v2/pokemon');
        $pokemons = $response->json()['results'];

        $locationIds = Location::pluck('id')->toArray();
        $shapeIds = Shape::pluck('id')->toArray();
        $abilityIds = Ability::pluck('id')->toArray();

        foreach ($pokemons as $pokemon) {
            $imageUrl = 'https://via.placeholder.com/300x300.png?text=' . urlencode($pokemon['name']);
            $imageContent = file_get_contents($imageUrl);
            $imagePath = 'images/pokemon/' . Str::random(40) . '.png';
            Storage::put($imagePath, $imageContent);

            $locationId =  $faker->randomElement($locationIds);
            $location = Location::find($locationId)->name;

            $pokemon = Pokemon::create([
                'name' => $pokemon['name'],
                'serial_number' => $faker->unique()->randomNumber(6),
                'shape_id' =>  $faker->randomElement($shapeIds),
                'location_id' => $locationId,
                'region' => PokemonsHelper::getRegion($location),
            ]);

            $numberOfAbilities = rand(1, 3);

            $randomAbilities =  $faker->randomElements($abilityIds, $numberOfAbilities);
            $pokemon->abilities()->attach($randomAbilities);

            $pokemon->images()->create(['image' => $imagePath]);
        }
    }
}
