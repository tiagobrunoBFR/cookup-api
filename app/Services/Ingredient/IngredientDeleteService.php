<?php

namespace App\Services\Ingredient;

use App\Models\Ingredient;

class IngredientDeleteService
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function __invoke()
    {
        return $this->delete();
    }

    private function delete()
    {
        $ingredient = Ingredient::find($this->id);

        if ($ingredient) {
            $ingredient->delete();
            return true;
        }

        return false;
    }
}
