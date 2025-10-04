@extends('buyer.headerFooter')

@section('title', 'Farmer Profile')

@section('body')
<style>
    .agri-card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 128, 0, 0.1);
        transition: 0.3s ease-in-out;
        background: #f9fff9;
    }
    .agri-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0, 128, 0, 0.2);
    }
    .agri-card img {
        border-bottom: 3px solid #4CAF50;
    }
    .agri-card-title {
        background: linear-gradient(90deg, #3aa655, #63c769);
        color: #fff;
        font-weight: bold;
        padding: 0.7rem;
        text-transform: uppercase;
        font-size: 1rem;
    }
    .agri-card-body {
        padding: 1rem;
        background: #fff;
    }
    .agri-card-body p {
        margin: 4px 0;
        color: #444;
        font-size: 0.9rem;
    }
    .btn-agri {
        background: linear-gradient(90deg, #4CAF50, #2e8b57);
        color: white;
        border-radius: 0.5rem;
        border: none;
        transition: 0.3s;
    }
    .btn-agri:hover {
        background: linear-gradient(90deg, #3b8f3b, #246b3a);
    }
</style>

<div class="container mt-5 pt-5">
    <h1 class="text-center text-success mb-4 fw-bold">
        {{ Session::get('c_login') ?? 'Farmer’s Crops' }}
    </h1>

    <div class="row g-4">
        @foreach($crops as $crop)
            @php($crop = App\Models\crop_import::where('id', $crop->crop_id)->first())
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="card agri-card h-100">
                    <img src="{{ url($crop->crop_image) }}" class="card-img-top" alt="crop" style="height:220px; object-fit:cover;">
                    <div class="agri-card-title text-center">{{ $crop->crop_name }}</div>
                    <div class="agri-card-body text-center">
                        <span class="badge bg-success mb-2">{{ $crop->condition }}</span>
                        <p><strong>Quantity:</strong> {{ $crop->crop_quantity }}</p>
                        <p><strong>Bid Rate:</strong> {{ $crop->bid_rate }} TK</p>
                        <p><strong>Last Date:</strong> {{ $crop->last_date_bidding }}</p>
                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ route('crop_details',['id'=>$crop->id]) }}" class="btn btn-agri">View Details</a>
                            <a href="{{ route('Bid_model',['id'=>$crop->id]) }}" class="btn btn-outline-success">Bid Now</a>
                            <a href="{{ route('wishlist_db',['id'=>$crop->id]) }}" class="btn btn-outline-danger" data-bs-toggle="tooltip" title="Add to wishlist">
                                <i class="far fa-heart"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
