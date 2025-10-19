<?php

namespace App\Http\Controllers;

use App\Models\Bid_message;
use App\Models\PayConfirmMessage;
use App\Models\user_register;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    /**
     * 🧾 Customer profile (bids list)
     */
    public function cust_profile($c_username)
    {
        $bids_crop = Bid_message::where('cust_username', $c_username)
            ->distinct()
            ->get(['crop_id']);
        return view('buyer.customer_profile', compact('bids_crop'));
    }

    /**
     * 💳 Customer payment confirmations
     */
    public function c_message()
    {
        $pay_confirms = PayConfirmMessage::where('cust_username', Session::get('c_username'))->get();
        return view('buyer.c_message', compact('pay_confirms'));
    }

    /**
     * ⚙️ Customer settings page
     */
    public function c_settings()
    {
        $user = user_register::where('username', Session::get('c_username'))->first();
        return view('buyer.c_settings', compact('user'));
    }

    /**
     * ✏️ Update customer profile
     */
    public function customerRegisterUpdate(Request $request)
    {
        $customer = user_register::where('username', Session::get('c_username'))->firstOrFail();

        $validated = $request->validate([
            'username'      => 'required|string|max:50|unique:user_registers,username,' . $customer->id,
            'mobile'        => 'required|digits_between:10,15|unique:user_registers,mobile,' . $customer->id,
            'dob'           => 'required|date',
            'division'      => 'required|string|max:100',
            'zip_code'      => 'nullable|numeric',
            'address'       => 'nullable|string|max:255',
            'gender'        => 'nullable|string',
            'password'      => 'nullable|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $customer->fill([
            'username' => $validated['username'],
            'mobile'   => $validated['mobile'],
            'dob'      => $validated['dob'],
            'division' => $validated['division'],
            'zip_code' => $request->zip_code,
            'address'  => $request->address,
            'gender'   => $request->gender,
        ]);

        if (!empty($validated['password'])) {
            $customer->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/customer_profiles'), $imageName);
            $customer->profile_pic = 'uploads/customer_profiles/' . $imageName;
        }

        $customer->save();

        // Update session data
        Session::put([
            'c_username' => $customer->username,
            'c_email'    => $customer->email,
            'c_mobile'   => $customer->mobile,
            'c_profile'  => $customer->profile_pic,
        ]);

        return redirect()->route('c_settings')->with('success', 'Profile updated successfully!');
    }

    /**
     * 🪪 NID Verification Upload
     */
    public function NID_verification(Request $request)
{
    // Check if user is logged in via session
    if (!Session::has('c_username')) {
        return redirect()->route('buyer.login')->with('error', 'Please login first!');
    }

    $request->validate([
        'nid_image'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'nid_image2' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = user_register::where('username', Session::get('c_username'))->first();

    if (!$user) {
        return redirect()->route('buyer.login')->with('error', 'Session expired. Please login again.');
    }

    // Store images inside "public/uploads/nids"
    if ($request->hasFile('nid_image')) {
        $nid1 = $request->file('nid_image');
        $nid1Name = time() . '_front.' . $nid1->getClientOriginalExtension();
        $nid1->move(public_path('uploads/nids'), $nid1Name);
        $user->NID_1 = 'uploads/nids/' . $nid1Name;
    }

    if ($request->hasFile('nid_image2')) {
        $nid2 = $request->file('nid_image2');
        $nid2Name = time() . '_back.' . $nid2->getClientOriginalExtension();
        $nid2->move(public_path('uploads/nids'), $nid2Name);
        $user->NID_2 = 'uploads/nids/' . $nid2Name;
    }

    $user->condition = 'verified';
    $user->save();

    Session::put('c_condition', 'verified');

    return redirect()->back()->with('success', 'NID uploaded successfully! Your account is now verified.');
}
    /**
     * 🚪 Logout buyer
     */
    public function logout()
    {
        Session::forget(['c_username', 'c_email', 'c_mobile', 'c_profile']);
        return redirect('/')->with('l_msg', 'Logout successfully');
    }
}
