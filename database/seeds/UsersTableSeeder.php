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
        $user->name_first = 'Superadmin';
        $user->name_last = 'bruker';
        $user->email = 'superadmin@example.com';
        $user->password = $password;
        $user->email_verified_at = Carbon::now();
        $user->remember_token = Str::random(10);
        $user->save();

        $user->assignRole('superadmin');
        $user->assignRole('admin');
        $user->assignRole('user');
        $user->save();
        
        // Create an admin user
        $user = new User;
        $user->name_first = 'Admin';
        $user->name_last = 'bruker';
        $user->email = 'admin@example.com';
        $user->password = $password;
        $user->email_verified_at = Carbon::now();
        $user->remember_token = Str::random(10);
        $user->save();
        
        $user->assignRole('admin');
        $user->assignRole('user');
        $user->save();
        
        // Create a regular user
        $user = new User;
        $user->name_first = 'Vanlig';
        $user->name_last = 'bruker';
        $user->email = 'user@example.com';
        $user->password = $password;
        $user->email_verified_at = Carbon::now();
        $user->remember_token = Str::random(10);
        $user->save();

        $user->assignRole('user');
        $user->save();
    }
}
