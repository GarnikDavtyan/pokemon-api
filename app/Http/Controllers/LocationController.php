<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Services\LocationService;
use Exception;

class LocationController extends Controller
{
    private $locationService;

    public function __construct(LocationService $service)
    {
        $this->locationService = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = $this->locationService->list();

        return $this->successResponse($locations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        try {
            $location = $this->locationService->store($request);

            return $this->successResponse($location, 'Location created successfully', 201);
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        return $this->successResponse($location);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        try {
            $location = $this->locationService->update($request, $location);

            return $this->successResponse($location, 'Location updated successfully');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $this->locationService->delete($location);

        return $this->successResponse(null, 'Location deleted successfully');
    }
}
