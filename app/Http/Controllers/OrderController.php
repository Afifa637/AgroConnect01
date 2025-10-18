<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CropImport;
use App\Models\PayConfirmMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Show payment form
     */
    public function paymentForm($id)
    {
        $confirms = PayConfirmMessage::findOrFail($id);
        return view('buyer.payment_form', compact('confirms'));
    }

    /**
     * Handle manual payment submission
     */
    public function manuallyPayment(Request $request)
    {
        $validated = $request->validate([
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

        // Fetch the crop
        $crop = CropImport::findOrFail($validated['crop_id']);

        // Ensure the crop has a farmer
        $f_username = $crop->username ?? null;

        if (!$f_username) {
            return back()->with('error', '❌ Unable to find farmer for this crop.');
        }

        // Create a new order record
        Order::create([
            'f_username'     => $f_username,
            'c_username'     => $validated['c_username'],
            'crop_id'        => $validated['crop_id'],
            'name'           => $validated['customer_name'],
            'email'          => $validated['customer_email'],
            'phone'          => $validated['customer_mobile'],
            'bid_price'      => $validated['bid_price'],
            'amount'         => $validated['pay_amount'],
            'address'        => $validated['address'],
            'division'       => $validated['division'],
            'zip'            => $validated['zip'],
            'status'         => 'Processing',
            'transaction_id' => $validated['transaction_id'],
            'currency'       => 'BDT',
        ]);

        // Update crop condition
        $crop->condition = 'Sold';
        $crop->save();

        return redirect('/customer/order/messages')
            ->with('msg', '✅ Payment information saved successfully.');
    }

    /**
     * Farmer order messages
     */
    public function farmOrderMessages()
    {
        $f_username = Session::get('f_username');

        if (!$f_username) {
            return redirect()->route('login')
                ->with('error', 'Please login as a farmer to view your orders.');
        }

        $orders = Order::where('f_username', $f_username)
            ->orderByDesc('created_at')
            ->get();

        return view('farmer.orders_info', compact('orders'));
    }

    /**
     * Customer order messages
     */
    public function custOrderMessages()
    {
        $c_username = Session::get('c_username');

        $orders = Order::where('c_username', $c_username)
            ->orderByDesc('created_at')
            ->get();

        return view('buyer.orders_info', compact('orders'));
    }
}
