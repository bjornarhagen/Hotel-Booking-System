<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name_prefix' => [$faker->title, null][mt_rand(0, 1)],
        'name_first' => $faker->firstName,
        'name_last' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // 'email_verified_at' => [now(), null][mt_rand(0, 1)],
        'remember_token' => Str::random(10),
        'login_last' => [now(), null][mt_rand(0, 1)],
    ];
});
