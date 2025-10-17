<?php

namespace App\Http\Controllers;

use App\Models\farmer_register;
use App\Models\user_register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class RegisterLoginCheckController extends Controller
{
    /** ================= LOGIN ================= */
    public function login()
    {
        return view('home.login');
    }

    public function login_check(Request $request)
    {
        $request->validate([
            'register_as' => 'required|in:farmer,customer',
            'email'       => 'required|email',
            'password'    => 'required|string',
        ]);

        $role = $request->register_as;

        // Determine which table to query
        $user = $role === 'farmer'
            ? farmer_register::where('email', $request->email)->first()
            : user_register::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('login_error', 'Email not found, please SignUp.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('login_error', 'Email or password do not match.');
        }

        if ($user->action !== 'active') {
            return back()->with('login_error', 'Your account is disabled, contact admin.');
        }

        // Set session based on role
        if ($role === 'farmer') {
            Session::put([
                'f_username' => $user->username,
                'f_email'    => $user->email,
                'f_mobile'   => $user->mobile,
                'f_profile'  => $user->profile_pic,
            ]);
            return redirect()->route('f_home')->with('login_success', 'Welcome, Farmer!');
        } else {
            Session::put([
                'c_username' => $user->username,
                'c_email'    => $user->email,
                'c_mobile'   => $user->mobile,
                'c_profile'  => $user->profile_pic,
            ]);
            return redirect()->route('c_settings')->with('login_success', 'Welcome, Buyer!');
        }
    }

    /** ================= REGISTER ================= */
    public function signup()
    {
        return view('home.signup');
    }

    public function registerSave(Request $request)
    {
        $role = $request->register_as;

        $rules = [
            'register_as'       => 'required|in:farmer,customer',
            'username'          => 'required|alpha_num|min:3|unique:' . ($role === 'farmer' ? 'farmer_registers,username' : 'user_registers,username'),
            'email'             => 'required|email|unique:' . ($role === 'farmer' ? 'farmer_registers,email' : 'user_registers,email'),
            'mobile'            => ['required', 'regex:/^(01|8801)[3-9]\d{8}$/'],
            'dob'               => 'required|date',
            'division'          => 'required|string',
            'address'           => 'required|string',
            'zip_code'          => 'required|string|max:10',
            'gender'            => 'required|in:male,female',
            'password'          => ['required', 'string', 'min:5', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'password_confirm'  => 'required|same:password',
            'profile_pic'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'NID_1'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'NID_2'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $request->validate($rules);

        // Choose model dynamically
        $model = $role === 'farmer' ? new farmer_register() : new user_register();

        $model->register_as = $role;
        $model->username    = $request->username;
        $model->email       = $request->email;
        $model->mobile      = $request->mobile;
        $model->dob         = $request->dob;
        $model->division    = $request->division;
        $model->address     = $request->address;
        $model->zip_code    = $request->zip_code;
        $model->gender      = $request->gender;
        $model->password    = Hash::make($request->password);
        $model->profile_pic = $request->hasFile('profile_pic') ? $request->file('profile_pic')->store('profiles', 'public') : null;
        $model->NID_1       = $request->hasFile('NID_1') ? $request->file('NID_1')->store('nids', 'public') : null;
        $model->NID_2       = $request->hasFile('NID_2') ? $request->file('NID_2')->store('nids', 'public') : null;
        $model->action      = 'active';
        $model->condition   = 'unverified';
        $model->save();

        // Set session and redirect immediately after registration
        if ($role === 'farmer') {
            Session::put([
                'f_username' => $model->username,
                'f_email'    => $model->email,
                'f_mobile'   => $model->mobile,
                'f_profile'  => $model->profile_pic,
            ]);
            event(new Registered($model));
            return redirect()->route('f_home')->with('reg_success', 'Welcome, Farmer! Your account has been created.');
        } else {
            Session::put([
                'c_username' => $model->username,
                'c_email'    => $model->email,
                'c_mobile'   => $model->mobile,
                'c_profile'  => $model->profile_pic,
            ]);
            event(new Registered($model));
            return redirect()->route('c_settings')->with('reg_success', 'Welcome, Buyer! Your account has been created.');
        }
    }

    /** ================= PASSWORD RESET ================= */
    public function pw_change_link(Request $request)
    {
        $role = $request->register_as;

        $request->validate([
            'email' => 'required|exists:' . ($role === 'farmer' ? 'farmer_registers' : 'user_registers') . ',email',
        ]);

        // TODO: implement actual email send
        return redirect('/login')->with('reg_success', 'We sent a password reset link to your email.');
    }

    public function pw_change($role, $email)
    {
        return view('home.pw_change', compact('role', 'email'));
    }

    public function pass_change_save(Request $request, $role, $email)
    {
        $request->validate([
            'password'          => ['required', 'string', 'min:5', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/'],
            'password_confirm'  => 'required|same:password',
        ]);

        $model = $role === 'farmer'
            ? farmer_register::where('email', $email)->firstOrFail()
            : user_register::where('email', $email)->firstOrFail();

        $model->password = Hash::make($request->password);
        $model->save();

        return redirect('/login')->with('reg_success', 'Password changed successfully! Now login.');
    }
}
