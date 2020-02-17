<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\TechLabelUser;

$factory->define(TechLabelUser::class, function (Faker $faker) {
    return [
        'tech_label_id' => \App\Techlabel::orderByRaw('RAND()')->first()->id,
        'user_id' => \App\User::orderByRaw('RAND()')->first()->id,
        'level' => random_int(4, 10),
    ];
});
