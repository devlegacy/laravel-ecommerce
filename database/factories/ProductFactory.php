<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'        => $faker->unique()->word(),
        'description' => $faker->paragraph(),
        'image'       => $faker->imageUrl($width = 640, $height = 480, 'cats'),
        'price'       => $faker->numberBetween(100, 1000),
        'discount'    => $faker->numberBetween(2, 30),
        'stock'       => $faker->randomDigit,
    ];
});
