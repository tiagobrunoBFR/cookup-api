<?php
namespace App\Services\Ingredient;

use App\Models\Ingredient;
use App\Services\File\FileUploadService;

class IngredientCreateService
{
    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function __invoke()
    {
        return $this->upload();
    }

    public function upload()
    {
        $path = 'ingredients';

        $image = new FileUploadService($path, $this->request->file('image'));

        return $this->create($image()->id);
    }

    public function create($image_id)
    {
        $ingredient = Ingredient::create([
            'name' => $this->request->name,
            'image_id' => $image_id,
        ]);

        return $ingredient;
    }
}
