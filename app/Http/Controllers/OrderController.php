<?php

namespace App\Http\Controllers;

use App\Models\crop_import;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CropImport;
use App\Models\PayConfirmMessage;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Show payment form
     */
    public function paymentForm($id)
    {
        $confirm = PayConfirmMessage::findOrFail($id);
        return view('buyer.payment_form', compact('confirm'));
    }

    /**
     * Store manual payment and create an order
     */
    public function manuallyPayment(Request $request)
    {
        $validated = $request->validate([
            'f_username'     => 'required|string',
            'c_username'     => 'required|string',
            'crop_id'        => 'required|integer|exists:crop_imports,id',
            'customer_name'  => 'required|string|max:100',
            'customer_email' => 'required|email',
            'customer_mobile'=> 'required|string|max:20',
            'bid_price'      => 'required|numeric',
            'pay_amount'     => 'required|numeric',
            'address'        => 'required|string',
            'division'       => 'required|string',
            'zip'            => 'required|string|max:10',
            'transaction_id' => 'required|string',
        ]);

        $order = Order::create([
            'f_username'     => $validated['f_username'],
            'c_username'     => $validated['c_username'],
            'crop_id'        => $validated['crop_id'],
            'name'           => $validated['customer_name'],
            'email'          => $validated['customer_email'],
            'phone'          => $validated['customer_mobile'],
            'bid_price'      => $validated['bid_price'],
            'amount'         => $validated['pay_amount'],
            'status'         => 'Processing',
            'address'        => $validated['address'],
            'division'       => $validated['division'],
            'zip'            => $validated['zip'],
            'transaction_id' => $validated['transaction_id'],
            'currency'       => 'BDT',
        ]);

        // Update crop status
        $crop = crop_import::findOrFail($validated['crop_id']);
        $crop->condition = "Sold";
        $crop->save();

        return redirect()->route('cust_order_messages')
                         ->with('msg', 'Payment information sent successfully');
    }

    /**
     * Farmer order messages
     */
    public function farmOrderMessages()
    {
        $orders = Order::where('f_username', Session::get('f_username'))
                        ->latest()
                        ->get();

        return view('farmer.orders_info', compact('orders'));
    }

    /**
     * Customer order messages
     */
    public function custOrderMessages()
    {
        $orders = Order::where('c_username', Session::get('c_username'))
                        ->latest()
                        ->get();

        return view('buyer.orders_info', compact('orders'));
    }
}
