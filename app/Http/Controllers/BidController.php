<?php

namespace App\Http\Controllers;

use App\Models\Bid_message;
use App\Models\CropImport;
use App\Models\farmer_register;
use App\Models\user_register;
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
        $crop = CropImport::findOrFail($id);
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
        $request->validate([
            'crop_id'       => 'required|integer',
            'crop_name'     => 'required|string|max:100',
            'f_username'    => 'required|string|max:50',
            'cust_username' => 'required|string|max:50',
            'name'          => 'required|string|max:100',
            'bid_price'     => 'required|numeric|min:1',
            'message'       => 'nullable|string|max:255',
        ]);

        // Create new bid
        $bid = new Bid_message();
        $bid->crop_id       = $request->crop_id;
        $bid->crop_name     = $request->crop_name;
        $bid->f_username    = $request->f_username;
        $bid->cust_username = $request->cust_username;
        $bid->name          = $request->name;
        $bid->bid_price     = $request->bid_price;
        $bid->message       = $request->message ?? 'null';
        $bid->save();

        // Email notification to farmer
        $farmer = farmer_register::where('username', $request->f_username)->first();

        if ($farmer && $farmer->email) {
            Mail::send('farmer.Bid_notification', ['val' => $bid], function ($mail) use ($farmer) {
                $mail->to($farmer->email)
                     ->subject('New Bid Notification');
            });
        }

        return redirect('/')
            ->with('msg', '✅ Your bid was sent successfully.');
    }

    /**
     * Save a bid and return to crop details page
     */
    public function bid_msg_saved(Request $request)
    {
        $request->validate([
            'crop_id'       => 'required|integer',
            'crop_name'     => 'required|string|max:100',
            'f_username'    => 'required|string|max:50',
            'cust_username' => 'required|string|max:50',
            'name'          => 'required|string|max:100',
            'bid_price'     => 'required|numeric|min:1',
            'message'       => 'nullable|string|max:255',
        ]);

        // Create new bid
        $bid = new Bid_message();
        $bid->crop_id       = $request->crop_id;
        $bid->crop_name     = $request->crop_name;
        $bid->f_username    = $request->f_username;
        $bid->cust_username = $request->cust_username;
        $bid->name          = $request->name;
        $bid->bid_price     = $request->bid_price;
        $bid->message       = $request->message ?? 'null';
        $bid->save();

        return redirect()->route('crop_details', ['id' => $request->crop_id])
                         ->with('msg', '✅ Your bid was placed successfully.');
    }

    /**
     * Delete a bid
     */
    public function bid_delete($id, $crop_id)
    {
        $bid = Bid_message::findOrFail($id);
        $bid->delete();

        $crop = CropImport::findOrFail($crop_id);
        $bids_msg = Bid_message::where('crop_id', $crop_id)->get();

        return view('home.crop_details', compact('crop', 'bids_msg'))
               ->with('msg', '🗑️ Bid deleted successfully.');
    }

    /**
     * Save payment confirmation
     */
    public function pay_confirm_message(Request $request)
{
    $request->validate([
        'bid_message_id' => 'required|integer|exists:bid_messages,id',
        'account_id'     => ['required', 'regex:/^((01|8801)[3456789]\d{8})$/'],
        'crop_id'        => 'required|integer',
        'f_username'     => 'required|string|max:50',
        'crop_name'      => 'required|string|max:100',
        'cust_username'  => 'required|string|max:50',
        'account_type'   => 'required|string|max:50',
        'confirm_price'  => 'required|numeric|min:1',
        'message'        => 'nullable|string|max:255',
    ]);

    $msg = new PayConfirmMessage();
    $msg->crop_id        = $request->crop_id;
    $msg->bid_message_id = $request->bid_message_id;
    $msg->f_username     = $request->f_username;
    $msg->crop_name      = $request->crop_name;
    $msg->cust_username  = $request->cust_username;
    $msg->account_type   = $request->account_type;
    $msg->account_id     = $request->account_id;
    $msg->confirm_price  = $request->confirm_price;
    $msg->message        = $request->message ?? null;
    $msg->save();

    return back()->with('msg', '💰 Your confirmation message was sent successfully.');
}

}
