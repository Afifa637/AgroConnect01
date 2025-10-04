@extends('buyer.headerFooter')

@section('title', 'Customer Profile')

@section('body')
<style>
    .agri-card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        background: #f9fff9;
        box-shadow: 0 5px 20px rgba(0, 128, 0, 0.1);
        transition: 0.3s ease-in-out;
    }
    .agri-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0, 128, 0, 0.2);
    }
    .agri-card img {
        border-bottom: 3px solid #4CAF50;
    }
    .agri-card-body {
        padding: 1rem;
        background: #fff;
        text-align: center;
    }
    .agri-card-body h5 {
        color: #2e7d32;
        font-weight: bold;
    }
    .btn-agri {
        background: linear-gradient(90deg, #4CAF50, #2e8b57);
        color: white;
        border: none;
        border-radius: 0.5rem;
        transition: 0.3s;
    }
    .btn-agri:hover {
        background: linear-gradient(90deg, #3b8f3b, #246b3a);
    }
</style>

<div class="container my-5 pt-5">
    @if($bids_crop->isEmpty())
        <div class="text-center py-5">
            <h4 class="text-muted">Your profile is empty — start bidding to see crops here!</h4>
        </div>
    @else
        <div class="row g-4">
            @foreach($bids_crop as $crop)
                @php($crop = App\Models\crop_import::where('id', $crop->crop_id)->first())
                <div class="col-lg-4 col-md-6">
                    <div class="card agri-card h-100">
                        <img src="{{ asset($crop['crop_image']) }}" alt="{{ $crop['crop_name'] }}" class="card-img-top" style="height:200px; object-fit:cover;">
                        <div class="agri-card-body">
                            <h5>{{ $crop['crop_name'] }}</h5>
                            <p class="text-muted mb-1">{{ $crop['condition'] }}</p>
                            <p class="mb-1">Quantity: <strong>{{ $crop['crop_quantity'] }}</strong></p>
                            <p class="mb-1">Bid Rate: <strong>{{ $crop['bid_rate'] }} TK</strong></p>
                            <p class="text-muted">Ends: {{ $crop['last_date_bidding'] }}</p>
                            <a href="{{ route('crop_details',['id'=>$crop['id']]) }}" class="btn btn-agri w-100 mt-2">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
