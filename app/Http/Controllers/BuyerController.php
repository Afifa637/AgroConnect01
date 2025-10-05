<?php

namespace App\Http\Controllers;

use App\Models\Bid_message;
use App\Models\pay_confirm_message;
use App\Models\PayConfirmMessage;
use App\Models\user_register;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request; // Add this line
class BuyerController extends Controller
{
    /**
     * Customer profile (bids list)
     */
    public function cust_profile($c_username)
    {
        $bids_crop = Bid_message::where('cust_username', $c_username)
            ->distinct()
            ->get(['crop_id']);
        return view('buyer.customer_profile', compact('bids_crop'));
    }

    /**
     * Customer payment confirmations
     */
    public function c_message()
    {
        $pay_confirms = PayConfirmMessage::where('cust_username', Session::get('c_username'))->get();
        return view('buyer.c_message', compact('pay_confirms'));
    }

    /**
     * Customer settings page
     */
    public function c_settings()
    {
        $user = user_register::where('username', Session::get('c_username'))->first();
        return view('buyer.c_settings', compact('user'));
    }

    /**
     * Farmer profile (public view for buyers)
     */
    public function farm_profile($f_username)
    {
        $crops = Bid_message::where('f_username', $f_username)
            ->distinct()
            ->get(['crop_id']);
        return view('buyer.farm_profile', compact('crops'));
    }

    public function customerRegisterUpdate(Request $request)
    {
        $customer = \App\Models\user_register::where('username', Session::get('c_username'))->firstOrFail();

        $validated = $request->validate([
            'username'      => 'required|string|max:50|unique:user_registers,username,' . $customer->id,
            'mobile'        => 'required|digits_between:10,15|unique:user_registers,mobile,' . $customer->id,
            'dob'           => 'required|date',
            'division'      => 'required|string|max:100',
            'zip_code'      => 'nullable|numeric',
            'address'       => 'nullable|string|max:255',
            'password'      => 'nullable|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update fields
        $customer->username = $validated['username'];
        $customer->mobile   = $validated['mobile'];
        $customer->dob      = $validated['dob'];
        $customer->division = $validated['division'];
        $customer->zip_code = $request->zip_code;
        $customer->address  = $request->address;

        // If password provided
        if (!empty($validated['password'])) {
            $customer->password = Hash::make($validated['password']);
        }

        // Handle profile picture
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/customer_profiles'), $imageName);
            $customer->profile_pic = 'uploads/customer_profiles/' . $imageName;
        }

        $customer->save();

        // Update session
        Session::put([
            'c_username' => $customer->username,
            'c_email'    => $customer->email,
            'c_mobile'   => $customer->mobile,
            'c_profile'  => $customer->profile_pic,
        ]);

        return redirect()->route('c_settings')->with('success', 'Profile updated successfully!');
    }

    public function logout()
    {
        Session::forget('c_username');
        return redirect('/')->with('l_msg', 'Logout successfully');
    }
    
}
