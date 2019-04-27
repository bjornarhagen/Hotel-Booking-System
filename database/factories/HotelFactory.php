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
        'brand_color_primary' => [substr($faker->hexColor, 1), null][mt_rand(0, 1)],
        'brand_color_accent' => [substr($faker->hexColor, 1), null][mt_rand(0, 1)],
        'brand_logo' => [$faker->imageUrl, null][mt_rand(0, 1)],
        'brand_icon' => [$faker->imageUrl, null][mt_rand(0, 1)],
        'website' => [$faker->domainName, null][mt_rand(0, 1)],
        'contact_phone' => [$faker->phoneNumber, null][mt_rand(0, 1)],
        'contact_email' => [$faker->email, null][mt_rand(0, 1)],
        'address_street' => [$faker->streetName . ' ' . $faker->buildingNumber, null][mt_rand(0, 1)],
        'address_city' => [$faker->city, null][mt_rand(0, 1)],
        'address_zip' => [$faker->postcode, null][mt_rand(0, 1)],
        'address_lat' => [$faker->latitude, null][mt_rand(0, 1)],
        'address_lon' => [$faker->longitude, null][mt_rand(0, 1)],
    ];
});
