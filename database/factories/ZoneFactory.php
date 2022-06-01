<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\City;
use App\Models\Zone;
use Faker\Generator as Faker;

$factory->define(Zone::class, function (Faker $faker) {
    return [
        'name'      => $faker->name,
        'mm_name'      => $faker->name,
        'city_id'   => function () {
            return City::all()->random()->id;
        },
    ];
});

$factory->state(City::class, 'city_id', function ($faker) {
    return [
        'city_id' => $faker->randomDigitNotNull,
    ];
});
