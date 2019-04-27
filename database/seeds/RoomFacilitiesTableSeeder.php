<?php

use App\RoomFacility;
use Illuminate\Database\Seeder;

class RoomFacilitiesTableSeeder extends Seeder
{
    public function run()
    {
        factory(RoomFacility::class, 100)->create();
    }
}