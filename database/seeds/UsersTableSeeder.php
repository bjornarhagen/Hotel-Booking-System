<?php

use App\User;
use App\Role;
use App\Hotel;
use App\HotelUser;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $hotel = Hotel::where('slug', 'havnehotellet-i-halden')->first();
        $role = Role::where('slug', 'hotel_manager')->first();

        $user = new User;
        $user->name_first = 'Example';
        $user->name_last = 'User';
        $user->email = 'admin@example.com';
        $user->password = Hash::make('password');
        $user->email_verified_at = Carbon::now();
        $user->remember_token = Str::random(10);
        $user->save();

        $hotel_user = new HotelUser;
        $hotel_user->user_id = $user->id;
        $hotel_user->hotel_id = $hotel->id;
        $hotel_user->role_id = $role->id;
        $hotel_user->save();

        $user = new User;
        $user->name_first = 'Ola';
        $user->name_last = 'Nordmann';
        $user->email = 'sensor';
        $user->password = Hash::make('sensor');
        $user->email_verified_at = Carbon::now();
        $user->remember_token = Str::random(10);
        $user->save();

        $hotel_user = new HotelUser;
        $hotel_user->user_id = $user->id;
        $hotel_user->hotel_id = $hotel->id;
        $hotel_user->role_id = $role->id;
        $hotel_user->save();

        if (app()->environment('local')) {
            factory(User::class, 50)->create();
        }
    }
}
