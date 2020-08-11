<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\File;
use Faker\Generator as Faker;

$factory->define(File::class, function (Faker $faker) {
    return [
        'mime' => $faker->mimeType,
        'path' => $faker->url,
        'name' => $faker->name,
        'size' => $faker->numerify()
    ];
});
