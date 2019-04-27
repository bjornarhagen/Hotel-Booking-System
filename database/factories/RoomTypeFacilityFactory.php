<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\RoomType;
use App\Facility;
use App\RoomTypeFacility;
use Faker\Generator as Faker;

$factory->define(RoomTypeFacility::class, function (Faker $faker) {
    return [
        'room_type_id' => RoomType::inRandomOrder()->first(),
        'facility_id' => Facility::inRandomOrder()->first()
    ];
});
