<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePokemonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:pokemons',
            'location_id' => 'required|exists:locations,id',
            'shape_id' => 'required|exists:shapes,id',
            'abilities' => 'required|array',
            'abilities.*' => 'exists:abilities,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
