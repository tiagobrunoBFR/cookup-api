<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ingredient\IngredientUpdateRequest;
use App\Http\Requests\Ingredient\IngredientCreateRequest;
use App\Http\Resources\IngredientResource;
use App\Services\Ingredient\IngredientCreateService;
use App\Services\Ingredient\IngredientDeleteService;
use App\Services\Ingredient\IngredientListService;
use App\Services\Ingredient\IngredientShowService;
use App\Services\Ingredient\IngredientUpdateService;
use Illuminate\Http\Request;

class IngredientController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ingredients = new IngredientListService($request);

        return IngredientResource::collection($ingredients()->with('image')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IngredientCreateRequest $request
     * @param IngredientCreateService $ingredientCreateService
     * @return \Illuminate\Http\Response
     */
    public function store(IngredientCreateRequest $request)
    {
        $ingredient = new IngredientCreateService($request->name, $request->file('image'));

        return new IngredientResource($ingredient()->load('image'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ingredient = new IngredientShowService($id);

        if ($ingredient()) {
            return new IngredientResource($ingredient()->load('image'));
        }

        return  ResponseApi::json(ResponseApi::NOT_FOUND['status']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(IngredientUpdateRequest $request, $id)
    {
        $ingredient = new IngredientUpdateService($id, $request->name, $request->file('image'));

        if ($ingredient()) {
            return new IngredientResource($ingredient()->load('image'));
        }

        return  ResponseApi::json(ResponseApi::NOT_FOUND['status']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ingredient = new IngredientDeleteService($id);

        if ($ingredient()) {
            return  ResponseApi::json(ResponseApi::NO_CONTENT['status']);
        }

        return  ResponseApi::json(ResponseApi::NOT_FOUND['status']);
    }
}
