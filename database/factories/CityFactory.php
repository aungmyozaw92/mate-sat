<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\City;
use App\Models\Region;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    return [
        //
    ];
});

// $factory->state(Region::class, 'region_id', function ($faker) {
//     return [
//         'region_id' => $faker->randomDigitNotNull,
//     ];
// });
