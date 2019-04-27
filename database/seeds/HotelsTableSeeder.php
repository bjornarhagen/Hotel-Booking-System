<?php

use App\Hotel;
use Illuminate\Database\Seeder;

class HotelsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Hotel::class, 50)->create();
    }
}