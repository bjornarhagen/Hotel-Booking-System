<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Hotel;
use App\RoomType;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(RoomType::class, function (Faker $faker) {
    $hotel_name = $faker->unique()->name;

    return [
        'name' => $hotel_name,
        'slug' => Str::slug($hotel_name),
        'description' => [$faker->realText, null][mt_rand(0, 1)],
        'price' => $faker->numberBetween(500, 5000),
        'hotel_id' => Hotel::inRandomOrder()->first(),
    ];
});
