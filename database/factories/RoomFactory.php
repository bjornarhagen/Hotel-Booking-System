<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Room;
use App\RoomType;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    $groups = [1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'];

    return [
        'number' => $faker->numberBetween(1, 999),
        'group' => $groups[mt_rand(0, count($groups)-1)],
        'room_type_id' => RoomType::inRandomOrder()->first(),
    ];
});
