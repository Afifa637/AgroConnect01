<?php

namespace App\Http\Controllers;

use App\Models\Bid_message;
use App\Models\crop_import;
use App\Models\farmer_register;
use App\Models\PayConfirmMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BidController extends Controller
{
    /**
     * Show bid modal for a crop
     */
    public function Bid_model($id)
    {
        $crop = crop_import::findOrFail($id);
        $highestBid = Bid_message::where('crop_id', $id)->max('bid_price');

        return view('buyer.Bid_model', [
            'crop' => $crop,
            'owners' => $highestBid
        ]);
    }

    /**
     * Save a bid and notify farmer
     */
    public function bid_msg_save(Request $request)
    {
        $validated = $request->validate([
            'crop_id'       => 'required|integer',
            'crop_name'     => 'required|string|max:100',
            'f_username'    => 'required|string|max:50',
            'cust_username' => 'required|string|max:50',
            'name'          => 'required|string|max:100',
            'bid_price'     => 'required|numeric|min:1',
            'message'       => 'nullable|string|max:255',
        ]);

        $bid = Bid_message::create($validated);

        // Email farmer
        $farmer = farmer_register::where('username', $validated['f_username'])->first();
        if ($farmer && $farmer->email) {
            Mail::send('farmer.Bid_notification', ['val' => $bid], function ($mail) use ($farmer) {
                $mail->to($farmer->email)->subject('New Bid Notification');
            });
        }

        return redirect('/')->with('msg', '✅ Your bid was sent successfully.');
    }

    /**
     * Save a bid and return to crop details page
     */
    public function bid_msg_saved(Request $request)
    {
        $validated = $request->validate([
            'crop_id'       => 'required|integer',
            'crop_name'     => 'required|string|max:100',
            'f_username'    => 'required|string|max:50',
            'cust_username' => 'required|string|max:50',
            'name'          => 'required|string|max:100',
            'bid_price'     => 'required|numeric|min:1',
            'message'       => 'nullable|string|max:255',
        ]);

        Bid_message::create($validated);

        return redirect()->route('crop_details', ['id' => $validated['crop_id']])
                         ->with('msg', '✅ Your bid was placed successfully.');
    }

    /**
     * Delete a bid
     */
    public function bid_delete($id, $crop_id)
    {
        Bid_message::findOrFail($id)->delete();

        $crop = crop_import::findOrFail($crop_id);
        $bids_msg = Bid_message::where('crop_id', $crop_id)->get();

        return view('home.crop_details', compact('crop', 'bids_msg'))
            ->with('msg', '🗑️ Bid deleted successfully.');
    }

    /**
     * Save payment confirmation
     */
    public function pay_confirm_message(Request $request)
    {
        $validated = $request->validate([
            'account_id'    => ['required', 'regex:/^((01|8801)[3456789]\d{8})$/'],
            'crop_id'       => 'required|integer',
            'f_username'    => 'required|string',
            'crop_name'     => 'required|string',
            'cust_username' => 'required|string',
            'account_type'  => 'required|string',
            'confirm_price' => 'required|numeric|min:1',
            'message'       => 'nullable|string|max:255',
        ]);

        PayConfirmMessage::create($validated);

        return back()->with('msg', '💰 Payment confirmation message sent successfully.');
    }
}
