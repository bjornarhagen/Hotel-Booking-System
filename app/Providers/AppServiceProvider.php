<?php

namespace App\Providers;

use Auth;
use Blade;
use App\Role;
use App\Hotel;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootSetTimeLocale();
        $this->bootBladeHotelRole();
    }
    
    private function bootSetTimeLocale()
    {
        $time_locale = config('app.time_locale');
        setlocale(LC_TIME, $time_locale);
    }
    
    private function bootBladeHotelRole()
    {
        $user = Auth::user();
        Blade::if('hotel_role', function (Hotel $hotel, String $role) {
            $role = Role::where('slug', $role)->first();
            
            if ($role === null) {
                return false;
            }

            return $user->hasRoleAtHotel($hotel, $role);
        });
    }
}
