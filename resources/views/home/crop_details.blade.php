@extends('home.headerFooter')

@section('title', 'Crop Details')

@section('body')
@php use Carbon\Carbon; @endphp

<div class="container my-5">
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="text-success fw-bold">🌿 Crop Details</h1>
        @if(Session::get('msg'))
            <div class="alert alert-success mt-3">{{ Session::get('msg') }}</div>
        @endif
    </div>

    <div class="row g-4">
        <!-- Crop Image Slider -->
        <div class="col-lg-6">
            <div id="cropCarousel" class="carousel slide shadow rounded-4" data-bs-ride="carousel">
                <div class="carousel-inner rounded-4 overflow-hidden">
                    @if($crop->crop_image)
                        <div class="carousel-item active">
                            <img src="{{ asset($crop->crop_image) }}" class="d-block w-100" alt="Crop Image 1">
                        </div>
                    @endif
                    @if($crop->crop_image2)
                        <div class="carousel-item">
                            <img src="{{ asset($crop->crop_image2) }}" class="d-block w-100" alt="Crop Image 2">
                        </div>
                    @endif
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#cropCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#cropCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
                </button>
            </div>
        </div>

        <!-- Crop Info & Bidding -->
        <div class="col-lg-6">
            <div class="card border-success shadow-sm rounded-4 p-4">
                <h2 class="text-primary fw-bold">{{ $crop->crop_name }}</h2>
                <ul class="list-unstyled mb-3">
                    <li><strong>Quantity:</strong> {{ $crop->crop_quantity }}</li>
                    <li><strong>Location:</strong> {{ $crop->crop_location }}</li>
                    <li><strong>Bid Rate:</strong> {{ $crop->bid_rate }} TK</li>
                    <li><strong>Finished Date:</strong> {{ $crop->last_date_bidding }}</li>
                    <li><strong>Condition:</strong> {{ ucfirst($crop->condition) }}</li>
                </ul>
                <p>{{ $crop->crop_description }}</p>
                <small class="text-muted">Posted on: {{ $crop->created_at->format('d M, Y H:i') }}</small>

                <div class="mt-4">
                    <p><strong>Farmer:</strong>
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#farmerModal">
                            {{ $crop->username }}
                        </button>
                    </p>

                    @if(Session::get('c_username'))
                        @if(!Carbon::now()->greaterThan($crop->last_date_bidding))
                            <button class="btn btn-success w-100 mt-2" data-bs-toggle="modal" data-bs-target="#BidModal">
                                🌾 Place Your Bid
                            </button>
                        @else
                            <div class="alert alert-danger mt-2 text-center">Bidding Time Finished</div>
                        @endif
                    @else
                        <a class="btn btn-success w-100 mt-2" href="{{ route('login') }}">Login to Bid</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Farmer Details Modal -->
    <div class="modal fade" id="farmerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success shadow-lg rounded-4">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">👩‍🌾 Farmer Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                @php($details = App\Models\farmer_register::where('username', $crop->username)->first())
                <div class="modal-body">
                    <table class="table table-bordered table-striped text-center">
                        <tbody>
                            <tr><th>Username</th><td>{{ $details->username }}</td></tr>
                            <tr><th>Email</th><td>{{ $details->email }}</td></tr>
                            <tr><th>Mobile</th><td>{{ $details->mobile }}</td></tr>
                            <tr><th>Division</th><td>{{ $details->division }}</td></tr>
                            <tr><th>Address</th><td>{{ $details->address }}</td></tr>
                            <tr><th>Zip Code</th><td>{{ $details->zip_code }}</td></tr>
                            <tr><th>Gender</th><td>{{ ucfirst($details->gender) }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bidding Modal -->
    <div class="modal fade" id="BidModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success shadow-lg rounded-4">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">🌾 Place Your Bid</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('bid_msg_saved') }}" method="POST">
                        @csrf
                        <input type="hidden" name="crop_id" value="{{ $crop->id }}">
                        <input type="hidden" name="crop_name" value="{{ $crop->crop_name }}">
                        <input type="hidden" name="f_username" value="{{ $crop->username }}">
                        <input type="hidden" name="cust_username" value="{{ Session::get('c_username') }}">

                        @php($price = App\Models\Bid_message::where('crop_id', $crop->id)->max('bid_price'))
                        <div class="mb-3">
                            <strong>Base Bid Rate:</strong> {{ $crop->bid_rate }} TK
                        </div>
                        <div class="mb-3">
                            <strong>Best Bid:</strong> {{ $price ? $price.' TK' : 'No bids yet' }}
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Your Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bid Price (TK)</label>
                            <input type="number" name="bid_price" class="form-control" placeholder="Enter your bid"
                                   min="{{ $crop->bid_rate }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Message (optional)</label>
                            <textarea name="message" class="form-control" rows="2" placeholder="Enter a message"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Submit Bid</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Bids List -->
    <div class="mt-5">
        <h3 class="text-success mb-3">💰 Active Bids</h3>
        @forelse($bids_msg as $bid)
            <div class="card shadow-sm my-3 border-success rounded-4 p-3">
                <div class="d-flex justify-content-between">
                    <h5 class="mb-1">👤 {{ $bid->cust_username }}</h5>
                    <small class="text-muted">{{ $bid->created_at->format('d M, Y H:i') }}</small>
                </div>
                <p class="mb-2">Bid: <strong>{{ $bid->bid_price }} TK</strong></p>

                <div class="d-flex gap-2">
                    @if($bid->cust_username == Session::get('c_username') && !Carbon::now()->greaterThan($crop->last_date_bidding))
                        <a href="{{ route('bid_delete', ['id'=>$bid->id,'crop_id'=>$bid->crop_id]) }}"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Are you sure you want to delete this bid?');">
                            🗑 Delete
                        </a>
                    @endif

                    @if($crop->username == Session::get('f_username'))
                        <a target="_blank" href="{{ route('confirm_form', ['id'=>$bid->id]) }}"
                           class="btn btn-success btn-sm">
                            ✅ Confirm
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted">No bids found yet.</p>
        @endforelse
    </div>
</div>
@endsection
