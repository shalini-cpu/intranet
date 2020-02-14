<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Branch;
use App\Project;
use App\User;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => "P-Title. " . $faker->title . $faker->word,
        'desc' => $faker->paragraph,
        'url' => $faker->url,
        'dev_url' => $faker->url,
        'repo_url' => $faker->url,
        'delivered_on' => $faker->date(),
        'lead_by' => User::all()->random()->id,
        'product_manager_id' => User::orderByRaw('RAND()')->first()->id,
        'wip' => random_int(0, 1),
        'created_by' => User::orderByRaw('RAND()')->first()->id,
//        'branch_id' => Branch::orderByRaw('RAND()')->first()->id,
        'status' => random_int(0, 1),
    ];
});
