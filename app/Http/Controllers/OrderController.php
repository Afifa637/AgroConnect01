<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Models\crop_import;
use App\Models\pay_confirm_message;
use App\Models\PayConfirmMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class orderController extends Controller
{
    /**
     * Payment form view
     */
    public function payment_form($id)
    {
        $confirms = PayConfirmMessage::findOrFail($id);
        return view('buyer.payment_form', compact('confirms'));
    }

    /**
     * Manual payment submission
     */
    public function manually_payment(Request $request)
    {
        $validated = $request->validate([
            'f_username'      => 'required|string',
            'c_username'      => 'required|string',
            'crop_id'         => 'required|integer',
            'customer_name'   => 'required|string|max:100',
            'customer_email'  => 'required|email',
            'customer_mobile' => 'required|string|max:15',
            'bid_price'       => 'required|numeric|min:1',
            'pay_amount'      => 'required|numeric|min:1',
            'address'         => 'required|string|max:255',
            'division'        => 'required|string|max:100',
            'zip'             => 'required|string|max:10',
            'transaction_id'  => 'required|string|max:100',
        ]);

        DB::table('orders')->updateOrInsert([
            'f_username' => $validated['f_username'],
            'c_username' => $validated['c_username'],
            'crop_id'    => $validated['crop_id'],
        ], [
            'name'          => $validated['customer_name'],
            'email'         => $validated['customer_email'],
            'phone'         => $validated['customer_mobile'],
            'bid_price'     => $validated['bid_price'],
            'amount'        => $validated['pay_amount'],
            'status'        => 'Processing',
            'address'       => $validated['address'],
            'division'      => $validated['division'],
            'zip'           => $validated['zip'],
            'transaction_id'=> $validated['transaction_id'],
            'currency'      => 'BDT',
        ]);

        $crop = crop_import::findOrFail($validated['crop_id']);
        $crop->condition = 'Sold';
        $crop->save();

        return redirect('/customer/order/messages')
            ->with('msg', '✅ Payment information sent successfully.');
    }

    /**
     * Farmer’s orders
     */
    public function farm_order_messages()
    {
        $orders = order::where('f_username', Session::get('f_username'))
                       ->orderByDesc('created_at')
                       ->get();
        return view('farmer.orders_info', compact('orders'));
    }

    /**
     * Customer’s orders
     */
    public function cust_order_messages()
    {
        $orders = order::where('c_username', Session::get('c_username'))
                       ->orderByDesc('created_at')
                       ->get();
        return view('buyer.orders_info', compact('orders'));
    }
}
