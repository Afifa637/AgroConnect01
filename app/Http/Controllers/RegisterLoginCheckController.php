<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\farmer_register;
use App\Models\user_register;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RegisterLoginCheckController extends Controller
{
    use ValidatesRequests;

    /** Show login page */
    public function login()
    {
        return view('home.login');
    }

    /** Handle login */
    public function login_check(Request $request)
    {
        $request->validate([
            'register_as' => 'required|in:farmer,customer',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $role = $request->register_as;

        if ($role === 'farmer') {
            $user = farmer_register::where('email', $request->email)->first();
            $redirectRoute = '/farmer/home/page';
            $sessionKey = 'f_username';
        } else {
            $user = user_register::where('email', $request->email)->first();
            $redirectRoute = '/';
            $sessionKey = 'c_username';
        }

        if (!$user) {
            return redirect('/login')->with('login_error', 'Email not found, please SignUp.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect('/login')->with('login_error', 'Email or password do not match.');
        }

        if ($user->action !== 'active') {
            return redirect('/login')->with('login_error', 'Your account is disabled, contact admin.');
        }

        Session::put($sessionKey, $user->username);
        return redirect($redirectRoute)->with('login_success', 'Login successful!');
    }

    /** Show signup page */
    public function signup()
    {
        return view('home.signup');
    }

    /** Handle registration */
    public function registerSave(Request $request)
    {
        $role = $request->register_as;

        $rules = [
            'username' => 'required|alpha_num|min:3|unique:' . ($role === 'farmer' ? 'farmer_registers' : 'user_registers') . ',username',
            'email' => 'required|email|unique:' . ($role === 'farmer' ? 'farmer_registers' : 'user_registers') . ',email',
            'mobile' => ['required','regex:/^((01|8801)[3456789])(\d{8})$/'],
            'zip_code' => 'required|string|max:5',
            'password' => [
                'required',
                'string',
                'min:5',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'password_confirm' => 'required|same:password',
        ];

        $this->validate($request, $rules);

        $model = $role === 'farmer' ? new farmer_register() : new user_register();

        $model->register_as = $role;
        $model->username = $request->username;
        $model->email = $request->email;
        $model->mobile = $request->mobile;
        $model->dob = $request->dob;
        $model->division = $request->division;
        $model->address = $request->address;
        $model->zip_code = $request->zip_code;
        $model->gender = $request->gender;
        $model->password = Hash::make($request->password);
        $model->profile_pic = 'null';
        $model->action = 'active';
        $model->condition = 'verified';
        $model->NID_1 = 'empty';
        $model->NID_2 = 'empty';
        $model->save();

        return redirect('/signup')->with('reg_success', 'Registration successful! Please verify your email.');
    }

    /** Show password change request form */
    public function pw_change_link(Request $request)
    {
        $role = $request->register_as;

        $request->validate([
            'email' => 'required|exists:' . ($role === 'farmer' ? 'farmer_registers' : 'user_registers') . ',email',
        ]);

        // You can implement mail sending here
        return redirect('/login')->with('reg_success', 'We sent a password reset link to your email.');
    }

    /** Show password reset form */
    public function pw_change($role, $email)
    {
        return view('home.pw_change', compact('role', 'email'));
    }

    /** Save new password */
    public function pass_change_save(Request $request, $role, $email)
    {
        $request->validate([
            'password' => [
                'required','string','min:5',
                'regex:/[a-z]/','regex:/[A-Z]/','regex:/[0-9]/'
            ],
            'password_confirm' => 'required|same:password',
        ]);

        $model = $role === 'farmer' ? farmer_register::where('email', $email)->first() : user_register::where('email', $email)->first();

        $model->password = Hash::make($request->password);
        $model->save();

        return redirect('/login')->with('reg_success', 'Password changed successfully! Now login.');
    }
}
