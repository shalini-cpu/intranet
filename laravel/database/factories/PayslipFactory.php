<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MonthYear;
use App\Payslip;
use App\User;
use Faker\Generator as Faker;

$factory->define(Payslip::class, function (Faker $faker) {
    return [
        'user_id' => User::orderByRaw('RAND()')->first()->id,
        'url' => $faker->url,
        'month_year' => $faker->date(),
        'status' => rand(0, 1)
    ];
});