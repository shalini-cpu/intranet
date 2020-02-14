<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Attendance;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Attendance::class, function (Faker $faker) {

    $starts_at = Carbon::create($faker->date());
    $ends_at = Carbon::createFromFormat('Y-m-d H:i:s', $starts_at)->addHours($faker->numberBetween(1, 19));

    return [
        'user_id' => User::orderByRaw('RAND()')->first()->id,
        'date' => $faker->date(),
        'in_time' => $starts_at->toDateTimeString(),
        'out_time' => $ends_at->toDateTimeString(),
        'status' => rand(0, 1)
    ];
});
