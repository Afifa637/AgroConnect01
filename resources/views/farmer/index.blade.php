@extends('farmer.headerFooter')

@section('title', 'Farmer Dashboard')

@section('body')
<div class="py-5">
  <h3 class="text-success text-center">{{ Session::get('f_login') }}</h3>
  <div class="row g-4">

    <div class="col-lg-4 col-md-6">
      <div class="card h-100 shadow border-0">
        <img src="{{ url('final_eagri/img/home.png') }}" class="card-img-top" alt="Farmer Crops">
        <div class="card-body">
          <h5 class="card-title">Sell Crops</h5>
          <p class="card-text">Upload pictures of crops and add details to sell directly to buyers.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="card h-100 shadow border-0">
        <img src="{{ url('final_eagri/img/2.jpg') }}" class="card-img-top" alt="Bidding System">
        <div class="card-body">
          <h5 class="card-title">Crop Bidding</h5>
          <p class="card-text">Set minimum bid rates and time durations. Buyers can place competitive bids.</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4 col-md-6">
      <div class="card h-100 shadow border-0">
        <img src="{{ url('final_eagri/img/service.jpg') }}" class="card-img-top" alt="Crop Selling">
        <div class="card-body">
          <h5 class="card-title">Confirm Sales</h5>
          <p class="card-text">At the end of bidding, crops are sold to the highest bidder confirmed by you.</p>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
