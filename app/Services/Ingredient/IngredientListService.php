<?php

namespace App\Services\Ingredient;

use App\Models\Ingredient;

class IngredientListService
{

    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function __invoke()
    {
        return $this->doQuery();
    }

    public function doQuery()
    {
        $ingredients = (new Ingredient)->newQuery();

        if ($this->request->has('name')) {
            $ingredients->where('name', 'like', '%' . $this->request->name . '%');
        }

        return $ingredients;
    }
}
