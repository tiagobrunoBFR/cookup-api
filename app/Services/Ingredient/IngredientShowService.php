<?php

namespace App\Services\Ingredient;

use App\Models\Ingredient;

class IngredientShowService
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function __invoke()
    {
        return $this->show();
    }

    private function show()
    {
        $ingredient = Ingredient::find($this->id);

        if ($ingredient) {
            return $ingredient;
        }

        return null;
    }
}
