<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest; // Ensure this class exists in the specified namespace
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'role' => 'required|in:user,farmer,admin',
    ]);

    $credentials = $request->only('email', 'password');
    $guard = $request->role; // which guard to use

    if (Auth::guard($guard)->attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        return match ($guard) {
            'admin'  => redirect()->route('a_home'),
            'farmer' => redirect()->route('f_home'),
            'user'   => redirect()->route('cust_profile', ['c_username' => Auth::guard('user')->user()->username]),
            default  => redirect()->route('dashboard'),
        };
    }

    return back()->withErrors([
        'email' => 'Invalid login credentials.',
    ]);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
