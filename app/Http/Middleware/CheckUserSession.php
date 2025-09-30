<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserSession
{
    public function handle(Request $request, Closure $next, $role)
    {
        if ($role === 'farmer' && !session()->has('f_username')) {
            return redirect('/login');
        }
        if ($role === 'customer' && !session()->has('c_username')) {
            return redirect('/login');
        }
        return $next($request);
    }
}
