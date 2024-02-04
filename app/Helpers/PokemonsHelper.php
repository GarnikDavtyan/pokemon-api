<?php

namespace App\Helpers;

class PokemonsHelper
{
    const SHAPES = [
        "head" => 1,
        "head_legs" => 2,
        "fins" => 3,
        "wings" => 4,
    ];

    const IMAGABLE_TYPES = [
        'pokemon', 
        'ability'
    ];

    public static function getRegion($location) 
    {
        $locations = [
            'Volcano', 
            'Cinnabar Gym',
            'Mansion',
            'Cinnabar Lab'
        ];

        return in_array($location, $locations) ? 'Kanto' : 'Hoenn'; 
    }
}
