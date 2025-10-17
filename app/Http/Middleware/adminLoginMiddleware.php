<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminLoginMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! Session::has('a_username')) {
            return redirect()->route('admin.login.page'); // redirect URL
        }

        return $next($request);
    }
}
