<?php

namespace App\Services\Ingredient;

use App\Models\Ingredient;
use App\Services\File\FileRemoveService;
use App\Services\File\FileUploadService;
use Illuminate\Support\Facades\DB;

class IngredientUpdateService
{
    private $id;
    private $name;
    private $image;

    public function __construct(int $id, string $name, $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
    }

    public function __invoke()
    {
        $ingredient = $this->make();
        return $ingredient;
    }


    private function make()
    {

        $ingredient = Ingredient::find($this->id);

        if ($ingredient) {
            DB::beginTransaction();
            $this->updateImage($ingredient);
            $ingredient->name = $this->name;
            $ingredient->save();
            DB::commit();
            return $ingredient;
        }

        return null;
    }

    public function updateImage(Ingredient $ingredient)
    {
        if ($this->image) {
            new FileRemoveService($ingredient->image);
            $image = new FileUploadService('ingredients', $this->image);
            $ingredient->image_id = $image()->id;
            $ingredient->save();
        }
    }
}
