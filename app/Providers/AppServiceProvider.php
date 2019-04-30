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
        $this->bootBladeHotelGuest();
        $this->bootBladeIcon();
    }
    
    private function bootSetTimeLocale()
    {
        $time_locale = config('app.time_locale');
        setlocale(LC_TIME, $time_locale);
    }
    
    private function bootBladeHotelRole()
    {
        Blade::if('hotel_role', function (Hotel $hotel, String $role) {
            $user = Auth::user();
            $role = Role::where('slug', $role)->first();
            
            if ($role === null) {
                return false;
            }

            return $user->hasRoleAtHotel($hotel, $role);
        });
    }

    private function bootBladeHotelGuest()
    {
        Blade::if('hotel_guest', function () {
            $user = Auth::user();
            return $user->isOnlyGuest();
        });
    }

    private function bootBladeIcon()
    {
        Blade::directive('icon', function ($arguments) {
            // Accept multiple arguments into the directive
            list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path = trim($path, "' ");
            $path = public_path('icons/' . $path . '.svg');
            $class = trim($class, "' ");

            // Set a fallback icon
            if (!file_exists($path)) {
                $path = public_path('icons/icon-missing.svg');
            }

            // Create the dom document
            $svg = new \DOMDocument();
            $svg->load($path);
            $svg->documentElement->setAttribute("class", trim('icon ' . $class));
            $svg->documentElement->setAttribute('aria-hidden', 'true');

            // Remove the title
            $svg_title = $svg->getElementsByTagName("title")->item(0);
            if ($svg_title != null) {
                $svg_head = $svg_title->parentNode;
                $svg_head->removeChild($svg_title);
            }

            $output = $svg->saveXML($svg->documentElement);
            $output = preg_replace('/\s+/', ' ', $output); // Remove line breaks and duplicate whitespace

            return $output;
        });
    }
}
