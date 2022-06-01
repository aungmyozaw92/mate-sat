<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\City;
use App\Models\Customer;
use App\Models\Zone;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name'      => $faker->name,
        'phone'      => $faker->unique()->e164PhoneNumber,
        'email'      => $faker->unique()->safeEmail,
        'address'      => $faker->address,
        'city_id'   => function () {
            return City::all()->random()->id;
        },
        'zone_id'   => function () {
            return Zone::all()->random()->id;
        },
        'is_active' => true
    ];
});

$factory->state(City::class, 'city_id', function ($faker) {
    return [
        'city_id' => $faker->randomDigitNotNull,
    ];
});

$factory->state(Zone::class, 'zone_id', function ($faker) {
    return [
        'zone_id' => $faker->randomDigitNotNull,
    ];
});
