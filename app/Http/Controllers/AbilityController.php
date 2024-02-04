<?php

namespace App\Http\Controllers;

use App\Models\Ability;
use App\Http\Requests\StoreAbilityRequest;
use App\Http\Requests\UpdateAbilityRequest;
use App\Services\AbilityService;
use Exception;

class AbilityController extends Controller
{
    private $abilityService;

    public function __construct(AbilityService $service)
    {
        $this->abilityService = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abilities = $this->abilityService->list();

        return $this->successResponse($abilities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbilityRequest $request)
    {
        try {
            $ability = $this->abilityService->store($request);

            return $this->successResponse($ability, 'Ability created successfully', 201);
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ability $ability)
    {
        return $this->successResponse($ability);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbilityRequest $request, Ability $ability)
    {
        try {
            $ability = $this->abilityService->update($request, $ability);

            return $this->successResponse($ability, 'Ability updated successfully');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ability $ability)
    {
        $this->abilityService->delete($ability);

        return $this->successResponse(null, 'Ability deleted successfully');
    }
}
