<?php
namespace App\Services\Ingredient;

use App\Models\Ingredient;
use App\Services\File\FileUploadService;

class IngredientService
{
    private $ingredient;
    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    }


    public function upload($image)
    {
        $path = 'ingredients';

        $image = new FileUploadService($path, $image);

        return $image;
    }

    public function create($request)
    {

        $image = $this->upload($request->file('image'))();

        $ingredient = $this->ingredient->create([
            'name' => $request->name,
            'image_id' => $image->id,
        ]);

        return $ingredient;
    }
}
