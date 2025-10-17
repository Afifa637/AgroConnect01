<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Closure;

class CustomerLoginCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('c_username')) {
            return redirect()->route('login')->with('error', 'Unauthorized access. Please login as a customer.');
        }

        return $next($request);
    }
}
