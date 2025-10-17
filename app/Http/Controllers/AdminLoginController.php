<?php

namespace App\Http\Controllers;

use App\Models\admin_register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminLoginController extends Controller
{
    use ValidatesRequests;

    public function a_login()
    {
        return view('admin.login');
    }

    public function admin_login_check(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:admin_registers,email',
            'password' => 'required|string',
        ]);

        $result = admin_register::where('email', $request->email)->first();

        if ($result) {
            // optionally check 'condition' verified flag if you use it
            if (Hash::check($request->password, $result->password)) {
                Session::put('a_username', $result->username);
                return redirect()->route('a_home')->with('a_login', 'Login successfully');
            } else {
                return redirect()->route('admin.login.page')->with('login_error', 'Password not match');
            }
        }

        return redirect()->route('admin.login.page')->with('login_error', 'Please SignUp');
    }

    public function admin_signup()
    {
        return view('admin.signup');
    }

    public function admin_registerSave(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|alpha_num|min:3|unique:admin_registers,username',
            'email' => 'required|email|unique:admin_registers,email',
            // mobile regex as string; adjust if needed for your locale
            'mobile' => ['required', 'regex:/^((01|8801)[3456789])([0-9]{8})$/'],
            'password' => [
                'required',
                'string',
                'min:5',
                'regex:/[a-z]/',      // at least one lowercase letter
                'regex:/[A-Z]/',      // at least one uppercase letter
                'regex:/[0-9]/',      // at least one digit
            ],
            'password_confirm' => 'required|same:password'
        ]);

        $regis = new admin_register();
        $regis->username = $request->username;
        $regis->email = $request->email;
        $regis->mobile = $request->mobile;
        $regis->dob = $request->dob;
        $regis->division = $request->division;
        $regis->address = $request->address;
        $regis->gender = $request->gender;
        $regis->password = Hash::make($request->password);
        $regis->profile_pic = "null";
        $regis->condition = "unverified";
        $regis->save();

        // optionally send verification mail (commented)
        // $data = $regis->toArray();
        // Mail::send('admin.verification_mail', ['val' => $data], function ($message) use ($data) {
        //     $message->to($data['email']);
        //     $message->subject('verification_mail');
        // });

        return redirect()->route('admin.login.page')->with('msg', 'Registration successful, please verify your account');
    }

    public function admin_account_verify($username)
    {
        $farm = admin_register::where('username', $username)->first();
        if ($farm) {
            $farm->condition = "verified";
            $farm->save();
            return redirect()->route('admin.login.page')->with('msg', 'Verified successfully');
        }
        return redirect()->route('admin.login.page')->with('msg', 'User not found');
    }

    public function admin_pw_change_link(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|exists:admin_registers,email',
        ]);

        $data = $request->toArray();
        // send pw change mail (commented)
        // Mail::send('admin.pw_change_mail', ['val' => $data], function ($message) use ($data){
        //     $message->to($data['email']);
        //     $message->subject('pw_change_mail');
        // });

        return redirect()->route('admin.login.page')->with('msg', 'We sent mail for change password');
    }

    public function admin_pw_change($email)
    {
        return view('admin.admin_pw_change', compact('email'));
    }

    public function admin_pass_change_save(Request $request, $email)
    {
        $this->validate($request, [
            'password' => [
                'required',
                'string',
                'min:5',
                'regex:/[a-z]/',      // at least one lowercase letter
                'regex:/[A-Z]/',      // at least one uppercase letter
                'regex:/[0-9]/',      // at least one digit
            ],
            'password_confirm' => 'required|same:password'
        ]);

        $pw_change = admin_register::where('email', $email)->first();
        if ($pw_change) {
            $pw_change->password = Hash::make($request->password);
            $pw_change->save();
            return redirect()->route('admin.login.page')->with('msg', 'Password changed successfully. Now login.');
        }

        return redirect()->route('admin.login.page')->with('msg', 'User not found.');
    }

    public function adminregisterUpdate(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'mobile' => ['required', 'regex:/^((01|8801)[3456789])([0-9]{8})$/'],
        ]);

        $imageUrl = null;
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $imageName = time() . '_' . Str::slug(pathinfo($profileImage->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $profileImage->getClientOriginalExtension();
            $profileImage->storeAs('public/profile_images', $imageName);
            $imageUrl = Storage::url('profile_images/' . $imageName);
        }

        $regis = admin_register::where('id', $request->id)->firstOrFail();
        $regis->mobile = $request->mobile;
        $regis->dob = $request->dob;
        $regis->division = $request->division;
        $regis->address = $request->address;
        $regis->gender = $request->gender;
        if ($imageUrl) {
            $regis->profile_pic = $imageUrl;
        }

        $regis->save();
        return redirect()->route('a_settings')->with('msg', 'Update Successfully');
    }
}
