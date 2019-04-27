<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Role;
use App\Hotel;
use Exception;
use \Illuminate\Http\Request;

class CheckHotelRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed $role - string or array of role name(s)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::guest()) {
            $request->session()->flash('error', 'You must be logged in.');

            return redirect()->back();
        }

        $hotel = $request->route('hotel');
        if (!$hotel instanceof Hotel) {
            throw new Exception('Couldn\'t find the hotel in the route parameters');
        }

        $user = $request->user();

        if (is_array($role)) {
            $roles = $role;
        } else {
            $roles = explode('|', $role);
        }

        foreach($roles as $role) {
            $role = Role::where('slug', $role)->first();

            if ($role === null) {
                throw new Exception('Couldn\'t find the role ' . $role);
            }

            if (!$user->hasRoleAtHotel($hotel, $role)) {
                $error_message = __('Only :role have access.', [
                    'role' => __($role->name)
                ]);
                $request->session()->flash('error', $error_message);

                return redirect()->back();
            }
        }


        return $next($request);
    }
}
