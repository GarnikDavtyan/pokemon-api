<?php

namespace App\Http\Controllers;

use App\Helpers\PokemonsHelper;
use App\Services\ImageService;

class ImageController extends Controller
{
    private $imageService;

    public function __construct(ImageService $service)
    {
        $this->imageService = $service;
    }

    public function getImage(string $type, int $id)
    {
        if (!in_array($type, PokemonsHelper::IMAGABLE_TYPES)) {
            return $this->errorResponse('Invalid image type', 400);
        }
        $image = $this->imageService->getImage($type, $id);

        return $this->successResponse($image);
    }
}
