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
        ->where(function($q) use ($query) {
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
    $user = Farmer_register::where('username', Session::get('f_username'))->firstOrFail();

    $user->username = $request->username;
    $user->email = $request->email;
    $user->mobile = $request->mobile;

    if ($request->hasFile('profile_pic')) {
        $file = $request->file('profile_pic');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('profile_pics'), $filename);
        $user->profile_pic = 'profile_pics/' . $filename;
    }

    $user->save();

    return redirect()->back()->with('msg', 'Profile updated successfully');
}

    /**
     * Farmer settings page
     */
    public function f_settings()
    {
        $user = Farmer_register::where('username', Session::get('f_username'))->first();
        return view('farmer.f_settings', compact('user'));
    }

    /**
     * NID verification upload
     */
    public function NID_verification(Request $request)
    {
        $NidImage = $request->file('nid_image');
        $NidImage2 = $request->file('nid_image2');
        $currentTime = time();

        $imageUrl = null;
        $imageUrl2 = null;

        if ($NidImage) {
            $imageName = $currentTime . '.' . $NidImage->getClientOriginalName();
            $directory = 'public/nid_images/';
            $imageUrl = $directory . $imageName;
            $NidImage->move($directory, $imageName);
        }

        if ($NidImage2) {
            $imageName = $currentTime . '.' . $NidImage2->getClientOriginalName();
            $directory = 'public/nid_images/';
            $imageUrl2 = $directory . $imageName;
            $NidImage2->move($directory, $imageName);
        }

        if (Session::has('f_username')) {
            $regis = Farmer_register::where('username', Session::get('f_username'))->first();
            $regis->NID_1 = $imageUrl;
            $regis->NID_2 = $imageUrl2;
            $regis->save();

            return redirect('/farmer')->with('msg', 'NID upload Successfully');
        } elseif (Session::has('c_username')) {
            $regis = User_register::where('username', Session::get('c_username'))->first();
            $regis->NID_1 = $imageUrl;
            $regis->NID_2 = $imageUrl2;
            $regis->save();

            return redirect('/customer')->with('msg', 'NID upload Successfully');
        }
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
