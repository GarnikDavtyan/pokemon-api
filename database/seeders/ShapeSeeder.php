<?php

namespace Database\Seeders;

use App\Helpers\PokemonsHelper;
use App\Models\Shape;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShapeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach(array_keys(PokemonsHelper::SHAPES) as $shape) {
            Shape::create(['name' => $shape]);
        }
    }
}
