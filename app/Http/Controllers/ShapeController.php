<?php

namespace App\Http\Controllers;

use App\Models\Shape;
use App\Http\Requests\StoreShapeRequest;
use App\Http\Requests\UpdateShapeRequest;
use App\Services\ShapeService;
use Exception;

class ShapeController extends Controller
{
    private $shapeService;

    public function __construct(ShapeService $service)
    {
        $this->shapeService = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shapes = $this->shapeService->list();

        return $this->successResponse($shapes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShapeRequest $request)
    {
        try {
            $shape = $this->shapeService->store($request);

            return $this->successResponse($shape, 'Shape created successfully', 201);
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shape $shape)
    {
        return $this->successResponse($shape);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShapeRequest $request, Shape $shape)
    {
        try {
            $shape = $this->shapeService->update($request, $shape);

            return $this->successResponse($shape, 'Shape updated successfully');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shape $shape)
    {
        $this->shapeService->delete($shape);

        return $this->successResponse(null, 'Shape deleted successfully');
    }
}
