<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckSession
{
    public function handle(Request $request, Closure $next, $role)
    {
        if ($role === 'customer' && !Session::has('c_username')) {
            return redirect('/login')->with('msg', 'Please login as a customer to continue.');
        }
        if ($role === 'farmer' && !Session::has('f_username')) {
            return redirect('/login')->with('msg', 'Please login as a farmer to continue.');
        }

        return $next($request);
    }
}
