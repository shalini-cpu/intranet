<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10)

        , "role_id" => Role::orderByRaw('RAND()')->first()->id
//        , "phone" => $faker->numberBetween(4000, 40000)
        , "mobile" => "[" . $faker->numberBetween(8000000, 999000000) . "]"
        , "emer_contact_no" => $faker->numberBetween(89000000, 999000000)
        , "emer_contact_name" => $faker->name
        , "designation" => $faker->jobTitle
        , "dob" => $faker->date()
        , "doj" => $faker->date()
        , "hire_date" => $faker->date()
        , "emp_id" => $faker->numberBetween(4000, 40000) . $faker->word()
        , "resignation_date" => $faker->date()
        , "city" => $faker->city
        , "address" => $faker->address
        , "reporting_to" => random_int(1, 40)
        , "bg" => $faker->randomElement(['AB+', 'A+', 'B+', 'O+'])
        , "profile_pic" => "img/default.jpg"
        , "resume_url" => "img/default.jpg"
        , "branch_id" => $faker->randomElement(['Banglore', 'Kolkata', 'Gujarat'])
        , "current_salary" => $faker->numberBetween(4000, 40000)
        , "user_type" => $faker->randomElement([1, 2, 3, 4, 5])
        , "status" => $faker->randomElement([0, 1])
    ];
});

    