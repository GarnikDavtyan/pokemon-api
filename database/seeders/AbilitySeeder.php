<?php

namespace Database\Seeders;

use App\Models\Ability;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class AbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://pokeapi.co/api/v2/ability');
        $abilities = $response->json()['results'];

        $faker = Factory::create('ru_RU');

        foreach ($abilities as $ability) {
            $russianWord = $faker->realText(10, 1);
            Ability::create([
                'name_in_english' => $ability['name'],
                'name_in_russian' => $russianWord
            ]);
        }
    }
}
