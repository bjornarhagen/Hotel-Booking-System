<?php

use App\RoomTypeFacility;
use Illuminate\Database\Seeder;

class RoomTypeFacilitiesTableSeeder extends Seeder
{
    public function run()
    {
        factory(RoomTypeFacility::class, 100)->create();
    }
}