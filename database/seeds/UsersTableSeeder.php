<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Carbon\Carbon;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // A hash of "password".
        $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

        // Create a superadmin user
        $user = new User;
        $user->name_first = 'Admin';
        $user->name_last = 'user';
        $user->email = 'admin@example.com';
        $user->password = $password;
        $user->email_verified_at = Carbon::now();
        $user->remember_token = Str::random(10);
        $user->save();

        // Create an admin user
        $user = new User;
        $user->name_first = 'Hotel';
        $user->name_last = 'manager';
        $user->email = 'hm@example.com';
        $user->password = $password;
        $user->email_verified_at = Carbon::now();
        $user->remember_token = Str::random(10);
        $user->save();
        
        // Create a regular user
        $user = new User;
        $user->name_first = 'Hotel';
        $user->name_last = 'employee';
        $user->email = 'he@example.com';
        $user->password = $password;
        $user->email_verified_at = Carbon::now();
        $user->remember_token = Str::random(10);
        $user->save();



    }
}
