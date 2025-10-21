@extends('farmer.headerFooter')

@section('title', 'Farmer Dashboard')

@section('body')
<div class="py-5">
    <h3 class="text-success text-center">{{ Session::get('f_login') }}</h3>

    
{{-- Flash Message --}}
@if (session('login_success') || session('reg_success') || session('msg') || session('l_msg') || session('login_error')|| session('success'))
<div class="container mt-3">
    @if (session('login_success'))
        <div class="alert alert-success text-center">{{ session('login_success') }}</div>
    @endif
    @if (session('reg_success'))
        <div class="alert alert-success text-center">{{ session('reg_success') }}</div>
    @endif
    @if (session('msg'))
        <div class="alert alert-info text-center">{{ session('msg') }}</div>
    @endif
    @if (session('l_msg'))
        <div class="alert alert-warning text-center">{{ session('l_msg') }}</div>
    @endif
    @if (session('login_error'))
        <div class="alert alert-danger text-center">{{ session('login_error') }}</div>
    @endif
    @if (session('success'))
<div class="alert alert-success text-center">{{ session('success') }}</div>
@endif
</div>
@endif

<script>
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(el => el.remove());
}, 4000);
</script>

    <!-- Static cards -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow border-0">
                <img src="{{ asset('final_eagri/img/home.png') }}" class="card-img-top" alt="Farmer Crops">
                <div class="card-body">
                    <h5 class="card-title">Sell Crops</h5>
                    <p class="card-text">Upload pictures of crops and add details to sell directly to buyers.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow border-0">
                <img src="{{ asset('final_eagri/img/2.jpg') }}" class="card-img-top" alt="Bidding System">
                <div class="card-body">
                    <h5 class="card-title">Crop Bidding</h5>
                    <p class="card-text">Set minimum bid rates and time durations. Buyers can place competitive bids.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow border-0">
                <img src="{{ asset('final_eagri/img/service.jpg') }}" class="card-img-top" alt="Crop Selling">
                <div class="card-body">
                    <h5 class="card-title">Confirm Sales</h5>
                    <p class="card-text">At the end of bidding, crops are sold to the highest bidder confirmed by you.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Farmer crops section -->
    <h4 class="text-success mb-4">Your Uploaded Crops</h4>

    @if(isset($crops) && $crops->count() > 0)
        <div class="row g-4">
            @foreach($crops as $crop)
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow border-0">
                        <img src="{{ asset($crop->crop_image) }}" class="card-img-top" alt="{{ $crop->crop_name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $crop->crop_name }}</h5>
                            <p class="card-text">{{ $crop->crop_description }}</p>
                            <p><strong>Quantity:</strong> {{ $crop->crop_quantity }}</p>
                            <p><strong>Rate:</strong> {{ $crop->bid_rate }} Tk</p>
                            <p><strong>Bidding Ends:</strong> {{ $crop->last_date_bidding }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">
            You haven't uploaded any crops yet. <a href="{{ route('crop_import') }}">Add your first crop</a>.
        </div>
    @endif
</div>
@endsection
