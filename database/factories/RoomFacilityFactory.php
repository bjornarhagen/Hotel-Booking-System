<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Room;
use App\Facility;
use App\RoomFacility;
use Faker\Generator as Faker;

$factory->define(RoomFacility::class, function (Faker $faker) {
    return [
        'room_id' => Room::inRandomOrder()->first(),
        'facility_id' => Facility::inRandomOrder()->first()
    ];
});
