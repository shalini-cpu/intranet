<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Leave;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Leave::class, function (Faker $faker) {

    $starts_at = Carbon::create($faker->date());
    $ends_at = Carbon::createFromFormat('Y-m-d H:i:s', $starts_at)->addHours($faker->numberBetween(30, 300));

    return [
        'user_id' => User::orderByRaw('RAND()')->first()->id,
        'reason' => $faker->paragraph,
        'leave_type' => $faker->randomElement(['seek', 'annual', 'personal', 'carer', 'disability']),
        'from' => $starts_at,
        'to' => $ends_at,
        'approved_by' => User::all()->random()->id,
        'status' => rand(0, 1)
    ];
});
