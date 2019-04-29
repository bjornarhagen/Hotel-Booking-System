<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\Role;
use App\Hotel;
use Exception;
use \Illuminate\Http\Request;

class CheckSessionForValue
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  \String $session_key
     * @return mixed
     */
    public function handle(Request $request, Closure $next, String $session_key)
    {
        if (!$request->session()->has($session_key)) {
            return redirect()->back();
        }

        return $next($request);
    }
}
