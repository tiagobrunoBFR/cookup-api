<?php

namespace App\Services\Ingredient;

use App\Models\Ingredient;
use App\Services\File\FileUploadService;
use Illuminate\Support\Facades\DB;

class IngredientCreateService
{

    private $name;
    private $image;

    public function __construct(string $name, object $image)
    {
        $this->name = $name;
        $this->image = $image;
    }

    public function __invoke(): Ingredient
    {

        $ingredient = $this->make();

        return $ingredient;
    }

    private function make(): Ingredient
    {

        DB::beginTransaction();
        $image = new FileUploadService('ingredients', $this->image);

        $ingredient = Ingredient::create([
            'name' => $this->name,
            'image_id' => $image()->id,
        ]);

        DB::commit();

        return $ingredient;
    }
}
