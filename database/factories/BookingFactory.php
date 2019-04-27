<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Hotel;
use App\Booking;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    return [
        'hotel_id' => Hotel::inRandomOrder()->first()
    ];
});
