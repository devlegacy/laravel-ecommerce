<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use App\Models\Category;
use Faker\Generator as Faker;
use Picqer\Barcode\BarcodeGeneratorSVG;

$factory->define(Product::class, function (Faker $faker) {
    $barcode = $faker->unique()->ean13;
    $barcodeGeneratorSVG = new BarcodeGeneratorSVG();

    return [
        'category_id'         => fn () => Category::all()->random(),
        'barcode'             => $barcode,
        'barcode_svg'         => $barcodeGeneratorSVG->getBarcode($barcode, BarcodeGeneratorSVG::TYPE_EAN_13),
        'name'                => $faker->unique()->word(),
        'description'         => $faker->paragraph(),
        'image'               => $faker->imageUrl($width = 640, $height = 480, 'cats'),
        'price'               => $faker->numberBetween(100, 1000),
        'vat_rate'            => $faker->randomElement([0, 16]),
        'discount_rate'       => $faker->numberBetween(0, 30),
        'stock'               => $faker->randomDigit,
        'is_active'           => $faker->numberBetween(0, 1),
    ];
});
