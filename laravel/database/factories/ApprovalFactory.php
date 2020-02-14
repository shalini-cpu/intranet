<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Approval;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Approval::class, function (Faker $faker) {
    $model = $faker->randomElement(['attendances', 'feedback']);
    $model_id = DB::table($model)->orderByRaw('RAND()')->first()->id;
    return [
        'model' => $model,
        'model_id' => $model_id,
        'approved_by' => User::inRandomOrder()->where('role_id',2)->first()->id,
        'is_approved' => $faker->randomElement(['approved', 'rejected', 'hold'])
    ];
});
