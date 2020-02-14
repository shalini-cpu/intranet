<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Branch;
use Faker\Generator as Faker;

$factory->define(Branch::class, function (Faker $faker) {
    return [
        'location' => $faker->country,
        'city' => $faker->city,
        'address' => $faker->address,
        'mobile' => $faker->phoneNumber,
    ];
});
