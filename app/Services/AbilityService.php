<?php

namespace App\Services;

use App\Http\Requests\StoreAbilityRequest;
use App\Http\Requests\UpdateAbilityRequest;
use App\Models\Ability;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class AbilityService 
{
    public function list(): Collection
    {
        $abilities = Ability::all();

        return $abilities;
    }

    public function store(StoreAbilityRequest $request): Ability
    {
        $ability = Ability::create([
            'name_in_english' => $request->name_in_english,
            'name_in_russian' => $request->name_in_russian,
        ]);

        if ($request->hasFile('image')) {
            $image = Storage::putFile('images/ability', $request->file('image'));
            $ability->images()->create(compact('image'));
        }

        return $ability;
    }
    
    public function update(UpdateAbilityRequest $request, Ability $ability): Ability
    {
        $ability->update([
            'name_in_english' => $request->name_in_english,
            'name_in_russian' => $request->name_in_russian,
        ]);

        if($request->hasFile('image')) {
            if($ability->images()->exists()) {
                Storage::delete($ability->images->first()->image);
                $ability->images()->delete();
            }

            $image = Storage::putFile('images/ability', $request->file('image'));
            $ability->images()->create(compact('image'));
        }

        return $ability;
    }

    public function delete(Ability $ability): void
    {
        if($ability->images()->exists()) {
            Storage::delete($ability->images->first()->image);
            $ability->images()->delete();
        }
        
        $ability->delete();
    }
}