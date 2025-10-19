@extends('home.headerFooter')

@section('title', 'Crop Details')

@section('body')
@php
    use Carbon\Carbon;
    $now = Carbon::now();
    $end = Carbon::parse($crop->last_date_bidding);
    $diff = $now->diff($end);
    $highestBid = App\Models\Bid_message::where('crop_id', $crop->id)->max('bid_price');
@endphp

<div class="container my-5">
    <div class="text-center mb-4">
        <h2 class="text-success fw-bold">🌿 Crop Details</h2>
        @if(Session::get('msg'))
            <div class="alert alert-success mt-3">{{ Session::get('msg') }}</div>
        @endif
    </div>

    <div class="row g-4 align-items-start">
        <!-- Image Slider + Thumbnails -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-success rounded-4 p-3">
                <div id="mainImageContainer" class="mb-3">
                    <img id="mainImage" src="{{ url($crop->crop_image) }}" class="img-fluid rounded w-100" alt="Main Crop Image" style="max-height: 400px; object-fit: contain;">
                </div>

                <!-- Thumbnail Gallery -->
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    @if($crop->crop_image)
                        <img src="{{ url($crop->crop_image) }}" class="thumbnail-img active-thumb" alt="Thumbnail 1" onclick="changeImage(this)">
                    @endif
                    @if($crop->crop_image2)
                        <img src="{{ url($crop->crop_image2) }}" class="thumbnail-img" alt="Thumbnail 2" onclick="changeImage(this)">
                    @endif
                    @if($crop->crop_image3 ?? false)
                        <img src="{{ url($crop->crop_image3) }}" class="thumbnail-img" alt="Thumbnail 3" onclick="changeImage(this)">
                    @endif
                </div>
            </div>
        </div>

        <!-- Crop Info -->
        <div class="col-lg-6">
            <div class="card border-success shadow-sm rounded-4 p-4">
                <h3 class="text-primary fw-bold">{{ $crop->crop_name }}</h3>
                <p><strong>Quantity:</strong> {{ $crop->crop_quantity }}</p>
                <p><strong>Location:</strong> {{ $crop->crop_location }}</p>
                <p><strong>Base Bid Rate:</strong> {{ $crop->bid_rate }} TK</p>
                <p><strong>Highest Bid:</strong>
                    <span class="text-success fw-bold">
                        {{ $highestBid ? $highestBid . ' TK' : 'No bids yet' }}
                    </span>
                </p>

                <p><strong>Condition:</strong> {{ $crop->condition }}</p>
                <p><strong>Description:</strong> {{ $crop->crop_description }}</p>

                <div class="my-3">
                    <strong>⏰ Bidding Ends:</strong>
                    <span class="text-danger">{{ $crop->last_date_bidding }}</span>
                    <br>
                    <strong>⏳ Time Left:</strong>
                    @if($now->greaterThan($end))
                        <span class="text-danger fw-bold">Expired</span>
                    @else
                        <span class="text-success fw-bold">
                            {{ $diff->d }}d {{ $diff->h }}h {{ $diff->i }}m left
                        </span>
                    @endif
                </div>

                <small class="text-muted d-block mb-2">Posted on: {{ $crop->created_at }}</small>

                <div class="mt-3">
                    <p><strong>Farmer:</strong>
                        <button class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#farmerModal">
                            {{ $crop->username }}
                        </button>
                    </p>
                </div>

                <div class="mt-4">
                    @if(Session::get('c_username'))
                        @if(!$now->greaterThan($end))
                            <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#BidModal">
                                🌾 Bid Here
                            </button>
                        @else
                            <h5 class="text-danger text-center">Bidding Time Finished</h5>
                        @endif
                    @else
                        <a class="btn btn-success w-100" target="_blank" href="{{ route('login') }}">Login to Bid</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Farmer Details Modal -->
    <div class="modal fade" id="farmerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">👩‍🌾 Farmer Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                @php($details = App\Models\farmer_register::where('username', $crop->username)->first())
                <div class="modal-body">
                    <table class="table table-bordered table-striped text-center">
                        <tr><th>Username</th><td>{{ $details->username }}</td></tr>
                        <tr><th>Email</th><td>{{ $details->email }}</td></tr>
                        <tr><th>Mobile</th><td>{{ $details->mobile }}</td></tr>
                        <tr><th>Division</th><td>{{ $details->division }}</td></tr>
                        <tr><th>Address</th><td>{{ $details->address }}</td></tr>
                        <tr><th>Zip Code</th><td>{{ $details->zip_code }}</td></tr>
                        <tr><th>Gender</th><td>{{ $details->gender }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bidding Modal -->
    <div class="modal fade" id="BidModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success shadow-lg">
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

                        <div class="mb-2"><strong>Base Bid Rate:</strong> {{ $crop->bid_rate }} TK</div>

                        <div class="mb-3">
                            <strong>Highest Bid:</strong>
                            <span class="text-primary">
                                {{ $highestBid ? $highestBid . ' TK' : 'No bids yet' }}
                            </span>
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
                            <input type="text" name="message" class="form-control" placeholder="Enter message">
                        </div>

                        <button type="submit" class="btn btn-success w-100">Submit Bid</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Bids + Related -->
<div class="row mt-5">
    <!-- Active Bids -->
    <div class="col-lg-8">
        <h5 class="fw-bold mb-3">💰 Active Bids</h5>
        @forelse($bids_msg as $bid)
            <div class="card mb-3 shadow-sm p-3 border-success rounded-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-semibold">👤 {{ $bid->cust_username }}</div>
                        <div class="text-muted small">{{ $bid->message }}</div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success">{{ $bid->bid_price }} TK</div>
                        <small class="text-muted">{{ $bid->created_at->diffForHumans() }}</small>
                        <div class="mt-2 d-flex gap-2 justify-content-end">
                            @if ($bid->cust_username == Session::get('c_username') && !$now->greaterThan($end))
                                <a href="{{ route('bid_delete', ['id' => $bid->id, 'crop_id' => $bid->crop_id]) }}"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Delete this bid?')">Delete</a>
                            @endif
                            @if ($crop->username == Session::get('f_username'))
                                <a href="{{ route('confirm_form', ['id' => $bid->id]) }}" target="_blank"
                                    class="btn btn-success btn-sm">Confirm</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-muted">No bids yet. Be the first to bid!</div>
        @endforelse
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <div class="card shadow-sm p-3 mb-3">
            <h6 class="fw-bold">🏆 Best Bid</h6>
            <div class="display-6 fw-semibold text-success">
                {{ $highestBid ? $highestBid . ' TK' : 'No bids yet' }}
            </div>
        </div>

        <div class="card shadow-sm p-3 related">
            <h6 class="fw-bold mb-3">🌾 Related Crops</h6>
            @foreach (App\Models\CropImport::where('crop_type', $crop->crop_type)->where('id', '<>', $crop->id)->take(4)->get() as $rel)
                <a href="{{ route('crop_details', ['id' => $rel->id]) }}"
                    class="list-group-item list-group-item-action border-0 mb-2 p-2 rounded shadow-sm d-flex align-items-center gap-2">
                    <img src="{{ asset($rel->crop_image) }}" alt="{{ $rel->crop_name }}"
                        style="width: 60px; height: 50px; object-fit: cover; border-radius: 6px;">
                    <div>
                        <div class="small fw-semibold">{{ Str::limit($rel->crop_name, 36) }}</div>
                        <div class="small text-muted">{{ $rel->bid_rate }} TK</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
</div>

<!-- Farmer Modal -->
<div class="modal fade" id="farmerModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success shadow-lg">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title">👩‍🌾 Farmer Details</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        @php($details = App\Models\farmer_register::where('username', $crop->username)->first())
        <div class="modal-body">
            <table class="table table-bordered table-striped text-center">
                <tr><th>Username</th><td>{{ $details->username }}</td></tr>
                <tr><th>Email</th><td>{{ $details->email }}</td></tr>
                <tr><th>Mobile</th><td>{{ $details->mobile }}</td></tr>
                <tr><th>Division</th><td>{{ $details->division }}</td></tr>
                <tr><th>Address</th><td>{{ $details->address }}</td></tr>
                <tr><th>Zip Code</th><td>{{ $details->zip_code }}</td></tr>
                <tr><th>Gender</th><td>{{ $details->gender }}</td></tr>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Bid Modal -->
<div class="modal fade" id="BidModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success shadow-lg">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title">🌾 Place Your Bid</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form id="bid-form" action="{{ route('bid_msg_saved') }}" method="POST">
                @csrf
                <input type="hidden" name="crop_id" value="{{ $crop->id }}">
                <input type="hidden" name="crop_name" value="{{ $crop->crop_name }}">
                <input type="hidden" name="f_username" value="{{ $crop->username }}">
                <input type="hidden" name="cust_username" value="{{ Session::get('c_username') }}">

                <div class="mb-2 small text-muted"><strong>Base:</strong> {{ $crop->bid_rate }} TK</div>
                <div class="mb-3 small text-muted"><strong>Best Bid:</strong>
                    {{ $highestBid ? $highestBid . ' TK' : 'No bids yet' }}</div>

                <div class="mb-3">
                    <label class="form-label">Your Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Bid Price (TK)</label>
                    <input id="bid-price" type="number" name="bid_price" class="form-control"
                        min="{{ $highestBid ?? $crop->bid_rate }}"
                        value="{{ max($highestBid ?? $crop->bid_rate, $crop->bid_rate) }}" required>
                    <div class="form-text">Must be at least {{ $highestBid ?? $crop->bid_rate }} TK</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Message (optional)</label>
                    <textarea name="message" class="form-control" rows="2"></textarea>
                </div>

                <button type="submit" class="btn btn-success w-100">Submit Bid</button>
            </form>
        </div>
    </div>
</div>
</div>


<style>
.thumbnail-img {
    width: 90px;
    height: 70px;
    border-radius: 10px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s ease-in-out;
}
.thumbnail-img:hover {
    border-color: #198754;
    transform: scale(1.05);
}
.active-thumb {
    border-color: #198754;
}
</style>

<script>
function changeImage(el) {
    const main = document.getElementById('mainImage');
    main.src = el.src;
    document.querySelectorAll('.thumbnail-img').forEach(img => img.classList.remove('active-thumb'));
    el.classList.add('active-thumb');
}
</script>
@endsection
