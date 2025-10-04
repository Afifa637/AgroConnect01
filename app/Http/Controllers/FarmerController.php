<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Bid_message;
use App\Models\Crop_import;
use App\Models\Farmer_register;
use App\Models\User_register;
use App\Models\PayConfirmMessage;

class FarmerController extends Controller
{
    /**
     * Farmer Home Page
     */
    public function f_home()
    {
        $crops = Crop_import::where('username', Session::get('f_username'))->get();
        return view('farmer.index', compact('crops'));
    }

    public function searchCrops(Request $request)
    {
        $query = $request->input('q'); // get search term
        $username = Session::get('f_username'); // search only in this farmer's crops

        $crops = Crop_import::where('username', $username)
            ->where(function ($q) use ($query) {
                $q->where('crop_name', 'like', "%$query%")
                    ->orWhere('crop_type', 'like', "%$query%");
            })
            ->get();

        return view('farmer.crop_manage', compact('crops', 'query'));
    }

    /**
     * Show farmer bid messages
     */
    public function farm_bid_messages()
    {
        $messages = Bid_message::where('f_username', Session::get('f_username'))
            ->orderBy('created_at', 'desc')
            ->get();

        // attach buyer details
        foreach ($messages as $msg) {
            $msg->buyer = User_register::where('username', $msg->cust_username)->first();
        }

        return view('farmer.f_message', compact('messages'));
    }

    /**
     * Confirm form
     */
    public function confirm_form($id)
    {
        $bid = Bid_message::findOrFail($id);
        return view('farmer.confirm_form', compact('bid'))
            ->with('msg', 'Payment Confirm successfully');
    }

    /**
     * List all confirmed crops
     */
    public function confirm_crops()
    {
        $pay_confirms = PayConfirmMessage::where('f_username', Session::get('f_username'))->get();
        return view('farmer.confirm_crops', compact('pay_confirms'));
    }

    /**
     * Delete confirmed crop
     */
    public function delete_confirm($id)
    {
        $confirm = PayConfirmMessage::findOrFail($id);
        $confirm->delete();

        return redirect()->route('confirm_crops')
            ->with('msg', 'Delete Confirm for payment successfully');
    }

    /**
     * Farmer profile by username
     */
    public function fa_profile($f_username)
    {
        $user = Farmer_register::where('username', $f_username)->firstOrFail(); // single model
        $crops = Crop_import::where('username', $f_username)
            ->where('Action', '!=', 'deleted')
            ->get();

        return view('farmer.farmer_profile', compact('user', 'crops'));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $farmer = Farmer_register::where('username', Session::get('f_username'))->firstOrFail();

        // Validation
        $validated = $request->validate([
            'username'      => 'required|string|max:50|unique:farmer_registers,username,' . $farmer->id,
            'mobile'        => 'required|digits_between:10,15|unique:farmer_registers,mobile,' . $farmer->id,
            'dob'           => 'required|date',
            'division'      => 'required|string|max:100',
            'zip_code'      => 'nullable|numeric',
            'address'       => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update model fields
        $farmer->username = $validated['username'];
        $farmer->mobile   = $validated['mobile'];
        $farmer->dob      = $validated['dob'];
        $farmer->division = $validated['division'];
        $farmer->zip_code = $request->zip_code;
        $farmer->address  = $request->address;

        // Handle image upload
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/farmer_profiles'), $imageName);
            $farmer->profile_pic = 'uploads/farmer_profiles/' . $imageName;
        }

        $farmer->save();
        // Sync session data
        Session::put([
            'f_username' => $farmer->username,
            'f_email'    => $farmer->email,
            'f_mobile'   => $farmer->mobile,
            'f_profile'  => $farmer->profile_pic,
        ]);

        return redirect()->route('f_settings')->with('success', 'Profile updated successfully!');
    }

    /**
     * Farmer settings page
     */
    public function f_settings()
    {
        $user = Farmer_register::where('username', Session::get('f_username'))->first();

        if (!$user) {
            return redirect()->route('f_login')->withErrors(['msg' => 'Please log in first.']);
        }

        return view('farmer.f_settings', compact('user'));
    }
    /**
     * NID verification upload
     */
    public function NID_verification(Request $request)
    {
        $request->validate([
            'nid_image'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'nid_image2' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = 'uploads/nid_images/';
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }

        $front = $request->file('nid_image');
        $back  = $request->file('nid_image2');
        $time  = time();

        $file1 = $time . '_front.' . $front->getClientOriginalExtension();
        $file2 = $time . '_back.' . $back->getClientOriginalExtension();

        $front->move(public_path($path), $file1);
        $back->move(public_path($path), $file2);

        $farmer = Farmer_register::where('username', Session::get('f_username'))->first();

        if ($farmer) {
            $farmer->update([
                'NID_1' => $path . $file1,
                'NID_2' => $path . $file2,
            ]);

            return redirect()->route('f_settings')->with('success', 'NID uploaded successfully!');
        }

        return back()->withErrors(['msg' => 'Farmer session not found.']);
    }

    /**
     * Customer details by username
     */
    public function customer_profile($username)
    {
        $crops = Bid_message::where('cust_username', $username)
            ->distinct()
            ->get(['crop_id']);

        return view('farmer.customer_profile', compact('crops'));
    }

    /**
     * Logout
     */
    public function logout($name)
    {
        if ($name == "c_username") {
            Session::forget('c_username');
            if (!Session::has('c_username')) {
                return redirect('/')->with('l_msg', 'Logout successfully');
            }
        }

        if ($name == "f_username") {
            Session::forget('f_username');
            if (!Session::has('f_username')) {
                return redirect('/')->with('l_msg', 'Logout successfully');
            }
        } else {
            Session::forget('a_username');
            if (!Session::has('a_username')) {
                return redirect('/admin/login')->with('l_msg', 'Logout successfully');
            }
        }
    }
}
