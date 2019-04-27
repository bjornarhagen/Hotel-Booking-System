<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Role;
use App\User;
use App\Hotel;
use App\HotelUser;
use Faker\Generator as Faker;

$factory->define(HotelUser::class, function (Faker $faker) {
    static $combos = [];

    $user = User::inRandomOrder()->first();
    $hotel = Hotel::inRandomOrder()->first();
    $role = Role::inRandomOrder()->first();

    // Is combo already set? Get a new user.
    if (isset($combos[$user->id]) && in_array($hotel->id, $combos[$user->id])) {
        $user = User::inRandomOrder()->where('id', '!=', $user->id)->first();
    }

    if (isset($combos[$user->id])) {
        array_push($combos[$user->id], $hotel->id);
    } else {
        $combos[$user->id] = [$hotel->id];
    }

    return [
        'hotel_id' => $hotel->id,
        'user_id' => $user->id,
        'role_id' => $role->id,
    ];
});
