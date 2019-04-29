<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Hotel;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Hotel::class, function (Faker $faker) {
    $hotel_name = $faker->unique()->name;

    return [
        'name' => $hotel_name,
        'slug' => Str::slug($hotel_name),
        'description' => [$faker->realText, null][mt_rand(0, 1)],
        'parking_spots' => [$faker->numberBetween(1, 999), 0][mt_rand(0, 1)],
        'price_parking_spot' => [$faker->numberBetween(1, 300), 0][mt_rand(0, 1)],
        'price_meal_breakfast' => $faker->numberBetween(300, 2000),
        'price_meal_lunch' => $faker->numberBetween(300, 2000),
        'price_meal_dinner' => $faker->numberBetween(300, 2000),
        'brand_color_primary' => [substr($faker->hexColor, 1), null][mt_rand(0, 1)],
        'brand_color_accent' => [substr($faker->hexColor, 1), null][mt_rand(0, 1)],
        'brand_logo_id' => null,
        'brand_icon_id' => null,
        'website' => [$faker->domainName, null][mt_rand(0, 1)],
        'contact_phone' => [$faker->phoneNumber, null][mt_rand(0, 1)],
        'contact_email' => [$faker->email, null][mt_rand(0, 1)],
        'address_street' => $faker->streetName . ' ' . $faker->buildingNumber,
        'address_city' => $faker->city,
        'address_zip' => $faker->postcode,
        'address_lat' => [$faker->latitude, null][mt_rand(0, 1)],
        'address_lon' => [$faker->longitude, null][mt_rand(0, 1)],
    ];
});
