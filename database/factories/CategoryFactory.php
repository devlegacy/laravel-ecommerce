<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name'        => $faker->unique()->word(),
        'description' => $faker->paragraph(),
        'is_active'   => $faker->numberBetween(0, 1),
    ];
});
