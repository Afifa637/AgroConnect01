<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Closure;

class FarmerLoginCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('f_username')) {
            return redirect()->route('login')->with('error', 'Unauthorized access. Please login as a farmer.');
        }

        return $next($request);
    }
}
