<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\User;
use App\Project;
use App\Techlabel;
use App\Team;

$factory->define(Team::class, function (Faker $faker) {
    return [
        'user_id' => User::orderByRaw('RAND()')->first()->id,
        'project_id' => Project::all()->random()->id,
        'techlabel_id' => Techlabel::orderByRaw('RAND()')->first()->id,
        'status' => random_int(0, 1)
    ];
});