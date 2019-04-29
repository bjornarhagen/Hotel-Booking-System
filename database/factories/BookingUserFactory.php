<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\User;
use App\Room;
use App\Booking;
use App\BookingUser;
use Faker\Generator as Faker;

$factory->define(BookingUser::class, function (Faker $faker) {
    static $combos = [];

    $booking = Booking::inRandomOrder()->first();
    $user = User::inRandomOrder()->first();

    // Is combo already set? Get a new user.
    if (isset($combos[$user->id]) && in_array($booking->id, $combos[$user->id])) {
        $user = User::inRandomOrder()->where('id', '!=', $user->id)->first();
    }

    if (isset($combos[$user->id])) {
        array_push($combos[$user->id], $booking->id);
    } else {
        $combos[$user->id] = [$booking->id];
    }

    $price_wishes = [$faker->numberBetween(100, 1000), null, null][mt_rand(0, 2)];
    $price_parking = [$faker->numberBetween(20, 500), null, null][mt_rand(0, 2)];
    $price_meals = [$faker->numberBetween(500, 2000), null, null][mt_rand(0, 2)];
    $price_room = $faker->numberBetween(5000, 10000);
    $discount = [$faker->numberBetween(5000, 10000), null, null][mt_rand(0, 2)];
    
    $balance = $price_wishes + $price_parking + $price_meals + $price_room - $discount;
    $balance = [$balance, $balance/2, 0, -100][mt_rand(0, 3)];

    return [
        'booking_id' => $booking->id,
        'user_id' => $user->id,
        'room_id' => Room::inRandomOrder()->first(),
        'is_main_booker' => [true, false, false][mt_rand(0, 2)],
        'meal_breakfast' => [true, false][mt_rand(0, 1)],
        'meal_lunch' => [true, false][mt_rand(0, 1)],
        'meal_dinner' => [true, false][mt_rand(0, 1)],
        'parking' => [true, false][mt_rand(0, 1)],
        'date_check_in' => $faker->datetime,
        'date_check_out' => $faker->datetime,
        'special_wishes' => [$faker->realText, null][mt_rand(0, 1)],
        'price_wishes' => $price_wishes,
        'price_parking' => $price_parking,
        'price_meals' => $price_meals,
        'price_room' => $price_room,
        'discount' => $discount,
        'balance' => $balance
    ];
});
