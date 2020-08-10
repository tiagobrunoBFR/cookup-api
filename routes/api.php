<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('authenticate', 'Api\AuthController@authenticate');
Route::post('register', 'Api\AuthController@register');

Route::middleware('auth:api')->prefix('v1')->namespace('Api')->group(function () {

    Route::apiResource('ingredients', 'IngredientController');
});
