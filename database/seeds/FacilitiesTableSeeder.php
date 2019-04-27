<?php

use App\Facility;
use Illuminate\Database\Seeder;

class FacilitiesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Facility::class, 500)->create();
    }
}