<?php

namespace App\Services;

use App\Http\Requests\StoreShapeRequest;
use App\Http\Requests\UpdateShapeRequest;
use App\Models\Shape;
use Illuminate\Database\Eloquent\Collection;

class ShapeService 
{
    public function list(): Collection
    {
        $shapes = Shape::all();

        return $shapes;
    }

    public function store(StoreShapeRequest $request)
    {
        $shape = Shape::create(['name' => $request->name]);

        return $shape;
    }
    
    public function update(UpdateShapeRequest $request, Shape $shape): Shape
    {
        $shape->update(['name' => $request->name]);

        return $shape;
    }

    public function delete(Shape $shape): void
    {
        $shape->delete();
    }
}