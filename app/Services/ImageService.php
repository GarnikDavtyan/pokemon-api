<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageService 
{
    public function getImage(string $type, int $id) 
    {
        $image = Image::where('imageable_type', 'App\\Models\\' . ucfirst($type))
            ->where('imageable_id', $id)
            ->firstOrFail();

        $path = Storage::url($image->image);

        return $path;
    }
}