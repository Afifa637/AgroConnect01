<?php

namespace App\Http\Controllers;

use App\Models\Bid_message;
use App\Models\pay_confirm_message;
use App\Models\PayConfirmMessage;
use App\Models\user_register;
use Illuminate\Support\Facades\Session;

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
}
