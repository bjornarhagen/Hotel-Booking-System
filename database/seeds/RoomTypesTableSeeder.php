<?php

use App\RoomType;
use Illuminate\Database\Seeder;

class RoomTypesTableSeeder extends Seeder
{
    public function run()
    {
        factory(RoomType::class, 100)->create();
    }
}