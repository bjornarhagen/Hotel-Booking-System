<?php

use App\User;
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
        $user = new User;
        $user->name_first = 'Example';
        $user->name_last = 'User';
        $user->email = 'admin@example.com';
        $user->password = Hash::make('password');
        $user->email_verified_at = Carbon::now();
        $user->remember_token = Str::random(10);
        $user->save();

        factory(User::class, 50)->create();
    }
}
