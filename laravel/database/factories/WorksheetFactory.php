<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use App\User;
use App\Worksheet;
use Faker\Generator as Faker;

$factory->define(Worksheet::class, function (Faker $faker) {
    return array(
        'title' => "workTitle-" . $faker->word,
        'desc' => $faker->paragraph,
        'hours_spend' => random_int(2,8),
        'date' => $faker->date(),
        'task_type' => $faker->randomElement(["new-feture","bug-fixed","maintanace","feture-improvment","optimazation"]),
        'stack' => $faker->randomElement(["frontend","backend"]),
        'priority' => 10,
        'user_id' => User::all()->random()->id,
        'project_id' => Project::orderByRaw('RAND()')->first()->id,
        'status' => random_int(0, 1),
    );
});