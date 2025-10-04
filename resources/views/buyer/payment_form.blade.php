@extends('buyer.headerFooter')

@section('title', 'Payment Form')

@section('body')
<style>
    .agro-form {
        background: #f4fff7;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .agro-header {
        color: #1b4332;
    }
    label {
        font-weight: 500;
        color: #2d6a4f;
    }
</style>

<div class="container my-5">
    <div class="col-lg-8 mx-auto agro-form">
        <h2 class="text-center agro-header mb-3"><i class="fas fa-credit-card"></i> Payment Details</h2>
        <p class="text-muted">
            Please pay <strong class="text-success">{{$confirms->confirm_price}}৳</strong> to
            <strong>{{$confirms->account_type}}</strong> Account:
            <span class="fw-bold">{{$confirms->account_id}}</span> for order confirmation.
        </p>

        <form action="{{route('manually_payment')}}" method="post">
            @csrf

            <input type="hidden" name="crop_id" value="{{$confirms->crop_id}}">
            <input type="hidden" name="f_username" value="{{$confirms->f_username}}">
            <input type="hidden" name="c_username" value="{{Session::get('c_username')}}">

            <div class="row g-3">
                <div class="col-md-6">
                    <label>Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Customer Mobile</label>
                    <input type="text" name="customer_mobile" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" name="customer_email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Division</label>
                    <select class="form-select" name="division" required>
                        <option value="">Select Division</option>
                        <option>Dhaka</option><option>Rajshahi</option><option>Khulna</option>
                        <option>Chittagong</option><option>Barishal</option><option>Comilla</option><option>Rangpur</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label>ZIP</label>
                    <input type="text" name="zip" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Amount (৳)</label>
                    <input type="number" name="pay_amount" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Transaction ID</label>
                    <input type="text" name="transaction_id" class="form-control" required>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-success px-5">Send for Order</button>
            </div>
        </form>
    </div>
</div>
@endsection
