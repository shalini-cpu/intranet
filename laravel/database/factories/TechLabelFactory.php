<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Techlabel;
use Faker\Generator as Faker;

$factory->define(Techlabel::class, function (Faker $faker) {
    return [
        'name' => 'Nodejs-' . random_int(1, 100000000),
        'status' => random_int(0, 1),
    ];
});
