<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Bid_message;
use App\Models\CropImport;
use App\Models\Farmer_register;
use App\Models\User_register;
use App\Models\PayConfirmMessage;
use Illuminate\Support\Facades\Log; 
class FarmerController extends Controller
{
    public function __construct()
    {
        view()->composer('farmer.*', function ($view) {
            $username = Session::get('f_username');
            $user = Farmer_register::where('username', $username)->first();
            $view->with('user', $user);
        });
    }

    public function f_home()
    {
        $crops = CropImport::where('username', Session::get('f_username'))->paginate(10);
        return view('farmer.index', compact('crops',));
    }

    public function searchCrops(Request $request)
    {
        $query = $request->input('query', ''); // default to empty
        $username = Session::get('f_username');

        $crops = CropImport::where('username', $username)
            ->when($query != '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->whereRaw('LOWER(crop_name) LIKE ?', ['%' . strtolower($query) . '%'])
                        ->orWhereRaw('LOWER(crop_type) LIKE ?', ['%' . strtolower($query) . '%']);
                });
            })
            ->paginate(10)
            ->withQueryString();

        return view('farmer.manage_crops', compact('crops', 'query'));
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
        return view('farmer.confirm_form', compact('bid', 'user'))
            ->with('msg', 'Payment Confirm successfully');
    }
    public function confirmPayment(Request $request, $id)
    {
        $bid = Bid_message::findOrFail($id);
        $request->validate([
            'account_id'    => ['required', 'regex:/^((01|8801)[3456789]\d{8})$/'],
            'account_type'  => 'required|string|max:50',
            'confirm_price' => 'required|numeric|min:1',
            'message'       => 'nullable|string|max:255',
        ]);
        // Save payment confirmation
        $confirm = new PayConfirmMessage();
        $confirm->f_username = Session::get('f_username');
        $confirm->cust_username = $bid->cust_username;
        $confirm->crop_id = $bid->crop_id;
        $confirm->bid_message_id = $bid->id;
        $confirm->crop_name       = $bid->crop_name;
        $confirm->account_type    = $request->input('account_type');
        $confirm->account_id      = $request->input('account_id');
        $confirm->confirm_price   = $request->input('confirm_price');
        $confirm->message = $request->input('message');
        $confirm->save();

        // Close the crop’s bidding
        $crop = CropImport::find($bid->crop_id);
        if ($crop) {
            $crop->Action = 'Unpublished'; // mark bidding as closed
            $crop->save();
        }

        // Deactivate other bids for that crop
        Bid_message::where('crop_id', $bid->crop_id)
            ->where('id', '!=', $bid->id)
            ->update(['status' => 'inactive']);

        return redirect()->route('confirm_crops')
            ->with('msg', 'Payment confirmed and bidding closed for this crop.');
    }

    /**
     * List all confirmed crops
     */
    public function confirm_crops()
    {
        $pay_confirms = PayConfirmMessage::where('f_username', Session::get('f_username'))->get();
        return view('farmer.confirm_crops', compact('pay_confirms', 'user'));
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
        $crops = CropImport::where('username', $f_username)
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

        // Assign fields
        $farmer->fill([
            'username' => $validated['username'],
            'mobile'   => $validated['mobile'],
            'dob'      => $validated['dob'],
            'division' => $validated['division'],
            'zip_code' => $request->zip_code,
            'address'  => $request->address,
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
            $path = $request->file('profile_image')->store('profiles', 'public');
            $farmer->profile_pic = 'storage/' . $path;
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

    $username = Session::get('f_username');
    if (!$username) {
        return back()->withErrors(['msg' => 'Session expired or not logged in. Please login and try again.']);
    }
    $farmer = Farmer_register::where('username', $username)->first();
    if (!$farmer) {
        return back()->withErrors(['msg' => "Farmer record not found for username: {$username}"]);
    }

    $path = 'uploads/nid_images/';
    if (!file_exists(public_path($path))) {
        if (!mkdir(public_path($path), 0777, true) && !is_dir(public_path($path))) {
            Log::error("Failed to create NID upload directory: " . public_path($path));
            return back()->withErrors(['msg' => 'Server error creating NID directory.']);
        }
    }

    try {
        $front = $request->file('nid_image');
        $back  = $request->file('nid_image2');
        $time  = time();

        $file1 = $time . '_front.' . $front->getClientOriginalExtension();
        $file2 = $time . '_back.'  . $back->getClientOriginalExtension();

        $front->move(public_path($path), $file1);
        $back->move(public_path($path), $file2);

        // Explicit assign and save — more reliable for debugging than update()
        $farmer->NID_1 = $path . $file1;
        $farmer->NID_2 = $path . $file2;
        $farmer->condition = 'verified';
        $saved = $farmer->save();

        if (!$saved) {
            Log::error("Failed to save Farmer after NID upload", ['username' => $username, 'farmer_id' => $farmer->id]);
            return back()->withErrors(['msg' => 'Unable to update verification status.']);
        }

        // refresh session profile pic etc. (optional)
        Session::put('f_profile', $farmer->profile_pic);

        return redirect()->route('f_settings')->with('success', 'NID uploaded & account verified successfully!');
    } catch (\Throwable $e) {
        Log::error('NID upload error: ' . $e->getMessage(), ['username' => $username]);
        return back()->withErrors(['msg' => 'An error occurred while uploading NID. Please try again.']);
    }
}

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
    public function logout()
    {
        Session::forget('f_username');
        return redirect('/')->with('l_msg', 'Logout successfully');
    }
}
