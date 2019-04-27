<?php

use App\HotelUser;
use Illuminate\Database\Seeder;

class HotelUsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(HotelUser::class, 50)->create();
    }
}