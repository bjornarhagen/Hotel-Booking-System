<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'name' => 'Administrator',
            'slug' => 'admin'
        ]);

        Role::create([
            'name' => 'Hotellsjef',
            'slug' => 'hotel_manager'
        ]);

        Role::create([
            'name' => 'Hotellansatt',
            'slug' => 'hotel_employee'
        ]);
    }
}