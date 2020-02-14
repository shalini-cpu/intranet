<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Feedback;
use App\User;
use App\Worksheet;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
        'title' => $faker->jobTitle,
        'desc' => $faker->paragraph,
        'feedback_by' => User::all()->random()->id,
        'worksheet_id' => Worksheet::orderByRaw('RAND()')->first()->id,
        'rating' => random_int(2, 10),
        'is_accepted' => $faker->boolean,
        'status' => random_int(0, 1),
    ];
});
