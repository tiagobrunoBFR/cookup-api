<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ingredient;
use Faker\Generator as Faker;

$factory->define(Ingredient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image_id' => factory('App\Models\File')->create()->id
    ];
});
