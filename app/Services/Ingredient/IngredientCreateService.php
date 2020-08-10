<?php

namespace App\Services\Ingredient;

use App\Models\Ingredient;
use App\Services\File\FileUploadService;
use Illuminate\Support\Facades\DB;

class IngredientCreateService
{
    private $ingredient;

    public function __construct(Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;
    }

    public function create(string $name, object $image): Ingredient
    {
        DB::beginTransaction();
        $image_id = $this->upload($image);
        $ingredient = $this->make($name, $image_id);
        DB::commit();
        return $ingredient;
    }

    private function upload(object $image): int
    {
        $path = 'ingredients';

        $image = new FileUploadService($path, $image);

        return $image()->id;
    }

    private function make(string $name, int $image_id): Ingredient
    {

        $ingredient = Ingredient::create([
            'name' => $name,
            'image_id' => $image_id,
        ]);

        return $ingredient;
    }
}
