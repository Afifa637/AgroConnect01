<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;

class FarmerLoginCheck
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (!Session::has('f_username')) {
            return redirect('/login');
        }

        return $next($request);
    }
}
