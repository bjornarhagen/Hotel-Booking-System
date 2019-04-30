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
    public function handle(Request $request, Closure $next, $roles)
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
        $roles = explode('|', $roles);
        $user_has_access = false;

        // Check if user has any of the roles
        foreach($roles as $role) {
            $role = Role::where('slug', $role)->first();

            if ($role === null) {
                throw new Exception('Couldn\'t find the role ' . $role);
            }

            if ($user->hasRoleAtHotel($hotel, $role)) {
                $user_has_access = true;
                continue;
            }
        }

        // User doesn't have any of the required roles, send back
        if (!$user_has_access) {
            $request->session()->flash('error', __('You don\'t have access.'));
            return redirect()->back();
        }

        return $next($request);
    }
}
