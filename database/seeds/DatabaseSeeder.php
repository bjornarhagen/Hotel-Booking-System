<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);

        if (app()->environment('local')) {
            $this->call(UsersTableSeeder::class);
            $this->call(HotelsTableSeeder::class);
            $this->call(FacilitiesTableSeeder::class);
            $this->call(RoomTypesTableSeeder::class);
            $this->call(RoomsTableSeeder::class);
            $this->call(RoomFacilitiesTableSeeder::class);
            $this->call(RoomTypeFacilitiesTableSeeder::class);
            $this->call(HotelUsersTableSeeder::class);
            $this->call(BookingsTableSeeder::class);
            $this->call(BookingUsersTableSeeder::class);
        }
    }
}
