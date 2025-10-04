@extends('buyer.headerFooter')
@section('title', 'Bid Form')
@section('body')

<style>
    .bid-container {
        background: linear-gradient(145deg, #e8f5e9, #f1f8e9);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        max-width: 600px;
        margin: 4rem auto;
    }
    .btn-success {
        background-color: #43a047 !important;
    }
</style>

<div class="bid-container">
    <h3 class="text-center text-success mb-4">🌾 Place Your Bid</h3>
    <form action="{{route('bid_msg_save')}}" method="POST">
        @csrf
        <input type="hidden" name="crop_id" value="{{$crop->id}}">
        <input type="hidden" name="crop_name" value="{{$crop->crop_name}}">
        <input type="hidden" name="f_username" value="{{$crop->username}}">
        <input type="hidden" name="cust_username" value="{{Session::get('c_username')}}">

        <p><strong>Bid Base Rate:</strong> {{$crop->bid_rate}} TK</p>
        <p><strong>Current Best Bidder:</strong>
            {{$owners ?? 'No bids yet'}}
        </p>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
        </div>

        <div class="mb-3">
            <label>Bid Price</label>
            <input type="number" name="bid_price" class="form-control" placeholder="Enter Bid Amount" min="{{$crop->bid_rate}}" required>
        </div>

        <div class="mb-3">
            <label>Message (optional)</label>
            <input type="text" name="message" class="form-control" placeholder="Enter message (if any)">
        </div>

        <button type="submit" class="btn btn-success w-100">Submit Bid</button>
    </form>
</div>
@endsection
