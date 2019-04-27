<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Hotel;
use App\Facility;
use Faker\Generator as Faker;

$factory->define(Facility::class, function (Faker $faker) {
    $random_2_or_3_words = [$faker->unique()->words(2), $faker->unique()->words(3)][mt_rand(0, 1)];
    $facility_name = ucfirst(implode(' ', $random_2_or_3_words));

    $icons = ['wifi', 'wheelchair', 'elevator', 'bathtub', 'shower', 'bed', 'tv'];

    return [
        'name' => $facility_name,
        'slug' => Str::slug($facility_name),
        'icon' => $icons[mt_rand(0, count($icons)-1)],
        'hotel_id' => Hotel::inRandomOrder()->first(),
    ];
});
