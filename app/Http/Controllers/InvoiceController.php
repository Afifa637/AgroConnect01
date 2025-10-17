<?php

namespace App\Http\Controllers;

use App\Models\Bid_message;
use App\Models\user_register;
use App\Models\farmer_register;
use App\Models\order;
use App\Models\crop_import;
use App\Models\PayConfirmMessage;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function bids_download_invoice($id)
    {
        $Bid = Bid_message::findOrFail($id);
        $username = $Bid->cust_username;
        $user = user_register::where('username', $username)->first();
        $pdf = Pdf::loadView('farmer.bids_download_invoice', ['Bid' => $Bid, 'user' => $user]);
        return $pdf->stream('invoice.pdf');
    }

    public function pay_confirm_download_invoice($id)
    {
        $msg = PayConfirmMessage::findOrFail($id);
        $Bid = Bid_message::where('crop_id', $msg->crop_id)->firstOrFail();
        $username = $Bid->f_username;
        $user = farmer_register::where('username', $username)->first();
        $pdf = Pdf::loadView('buyer.pay_confirm_invoice', ['msg' => $msg, 'Bid' => $Bid, 'user' => $user]);
        return $pdf->stream('invoice.pdf');
    }
    public function order_download_invoice($id)
    {
        $order = order::findOrFail($id);
        $crop = crop_import::where('id', $order->crop_id)->first();
    
        // ✅ Corrected path to the Blade file
        $pdf = Pdf::loadView('farmer.order_download_invoice', [
            'order' => $order,
            'crop' => $crop
        ]);
        return $pdf->stream('invoice.pdf');
    }
    
}
