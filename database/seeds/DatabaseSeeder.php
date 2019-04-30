<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Hotel;
use App\Room;
use App\RoomType;
use App\HotelUser;

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

        // Make the hotel
        $hotel = new Hotel;
        $hotel->name = 'Havnehotellet i Halden';
        $hotel->slug = Str::slug($hotel->name);
        $hotel->brand_color_primary = '#AE9731';
        $hotel->brand_color_accent = '#000000';
        $hotel->website = 'https://havnehotellet-i-halden.no';
        $hotel->contact_email = 'post@hhih.no';
        $hotel->contact_phone = '6922334455';
        $hotel->address_street = 'Mathias Bjørns gate';
        $hotel->address_city = 'Halden';
        $hotel->address_zip = '1771';
        $hotel->address_lat = '59.1192366';
        $hotel->address_lon = '11.3751791';
        $hotel->parking_spots = 14;
        $hotel->price_parking_spot = 0;
        $hotel->price_meal_breakfast = 0;
        $hotel->price_meal_lunch = 100;
        $hotel->price_meal_dinner = 250;
        $hotel->save();

        $room_types = [
            'enkeltrom' => [
                'price' => 990,
                'count' => 10
            ],
            'dobbeltrom' => [
                'price' => 1290,
                'count' => 8
            ],
            'suite' => [
                'price' => 1990,
                'count' => 2
            ],
            'bryllupssuite' => [
                'price' => 2490,
                'count' => 1
            ]
        ];

        // Make room types
        foreach ($room_types as $key => $info) {
            $room_type = new RoomType;
            $room_type->hotel_id = $hotel->id;
            $room_type->name = ucfirst($key);
            $room_type->slug = Str::slug($room_type->name);
            $room_type->price = $info['price'];
            $room_type->save();

            for ($i=0; $i < $info['count']; $i++) { 
                $room = new Room;
                $room->room_type_id = $room_type->id;
                $room->group = $room_type->name[0];
                $room->number = $i+1;
                $room->save();
            }
        }

        $this->call(UsersTableSeeder::class);

        if (app()->environment('local')) {
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
