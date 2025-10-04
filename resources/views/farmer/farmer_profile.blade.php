@extends('farmer.headerFooter')
@section('body')
<style>
    /* profile section */
    .profile-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 40px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .profile-card h4 {
        color: green;
        font-weight: 700;
        margin-bottom: 20px;
    }
    /* crops section */
    #menu-section {
        padding: 1%;
    }
    .card-body {
        text-align: center;
    }
    .item-desc {
        background: rgb(165, 164, 164);
        border-radius: 0 0 10px 10px;
    }
    .item-name {
        background: green;
        color: white;
        padding: 10px;
        border-radius: 10px 10px 0 0;
    }
    .item-desc > p {
        font-size: 0.8rem;
        padding: 5px;
        font-weight: bold;
    }
    .card {
        transition: .4s;
        border: none;
        border-radius: 10px;
        overflow: hidden;
    }
    .card:hover {
        transform: scale(1.05);
    }
</style>
<div class="container my-5">
    {{-- ================= FARMER INFO ================= --}}
    <div class="profile-card">
        <h4><i class="fas fa-user me-2"></i>Farmer Profile</h4>
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="{{ asset($user->profile_pic ?? 'default.png') }}" class="img-thumbnail rounded-circle" width="150">
            </div>
            <div class="col-md-9">
                <table class="table table-borderless mb-0">
                    <tr><th>Name:</th><td>{{ $user->username ?? 'N/A'}}</td></tr>
                    <tr><th>Email:</th><td>{{ $user->email ?? 'N/A'}}</td></tr>
                    <tr><th>Mobile:</th><td>{{ $user->mobile }}</td></tr>
                    <tr><th>Division:</th><td>{{ $user->division }}</td></tr>
                    <tr><th>Address:</th><td>{{ $user->address }}</td></tr>
                    <tr><th>Joined:</th><td>{{ $user->created_at->format('d M, Y') }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= CROPS LIST ================= --}}
    <h4 class="text-success mb-4"><i class="fas fa-leaf me-2"></i>My Crops</h4>
    <div class="row" id="menu-section">
        @forelse($crops as $crop)
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <img class="card-img-top" src="{{ asset('storage/'.$crop->crop_image) }}" alt="{{ $crop->crop_name }}" height="200">
                        <div class="item-desc">
                            <h5 class="item-name">{{ $crop->crop_name }}</h5>
                            <p>Condition: {{ $crop->condition }}</p>
                            <p>Quantity: {{ $crop->crop_quantity }}</p>
                            <p>Bid Rate: {{ $crop->bid_rate }} TK</p>
                            <p>Last Date: {{ $crop->last_date_bidding }}</p>
                            <a class="btn btn-success btn-block" href="{{ route('crop_edit', $crop->id) }}">
                                Edit Crop
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center">
                <p class="text-muted">No crops added yet. <a href="{{ route('crop_import') }}">Add your first crop</a></p>
            </div>
        @endforelse
    </div>
</div>

@endsection
