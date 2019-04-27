<?php

use App\Booking;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Booking::class, 300)->create();
    }
}