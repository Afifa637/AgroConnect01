<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\admin_register;
use App\Models\farmer_register;
use App\Models\User;
use App\Models\user_register;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('home.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'role' => 'required|in:user,farmer,admin',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = $request->only([
            'role', 'username', 'email', 'password', 'mobile', 'dob', 
            'division', 'address', 'zip_code', 'gender', 'profile_pic', 'NID_1', 'NID_2'
        ]);

        $data['password'] = Hash::make($request->password);

         switch ($data['role']) {
            case 'farmer':
                $user = farmer_register::create($data);
                Auth::guard('farmer')->login($user);
                return redirect()->route('farmer.dashboard');
            case 'admin':
                $user = admin_register::create($data);
                Auth::guard('admin')->login($user);
                return redirect()->route('admin.dashboard');
            case 'user':
            default:
                $user = user_register::create($data);
                Auth::guard('web')->login($user); // default guard is web for buyers
                return redirect()->route('user.dashboard');
        }
    }
}
