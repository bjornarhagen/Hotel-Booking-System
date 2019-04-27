<?php

use App\Room;
use Illuminate\Database\Seeder;

class RoomsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Room::class, 1000)->create();
    }
}