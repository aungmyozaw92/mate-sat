<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'      => $faker->name,
        'item_code'      => $faker->unique()->randomNumber(4),
        'price'      => $faker->randomNumber(5),
        'description'      => $faker->text,
        'image_path'      => $faker->imageUrl($width = 640, $height = 480),
        'is_available'      => true,
        'category_id'   => function () {
            return Category::all()->random()->id;
        },
    ];
});

$factory->state(Category::class, 'category_id', function ($faker) {
    return [
        'category_id' => $faker->randomDigitNotNull,
    ];
});

