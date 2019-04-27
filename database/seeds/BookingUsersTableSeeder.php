<?php

use App\BookingUser;
use Illuminate\Database\Seeder;

class BookingUsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(BookingUser::class, 1000)->create();
    }
}