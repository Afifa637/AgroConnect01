@extends('home.headerFooter')

@section('title', $crop->crop_name ?? 'Crop Details')

@push('head')
<link href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" rel="stylesheet" />
<style>
  .gallery-thumb img { height:80px; object-fit:cover; cursor:pointer; }
  .seller-card img { width:64px; height:64px; object-fit:cover; border-radius:8px; }
  .badge-open { background:#198754; color:white; padding:.25rem .5rem; border-radius:.25rem; }
</style>
@endpush

@section('body')
@php use Carbon\Carbon; @endphp

<div class="container my-5">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent p-0">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('categories', ['crop_type' => $crop->crop_type]) }}">{{ optional(App\Models\categories_info::find($crop->crop_type))->categories_name ?? 'Category' }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">{{ $crop->crop_name }}</li>
    </ol>
  </nav>

  <div class="row g-4">
    <!-- Gallery -->
    <div class="col-lg-6">
      <div class="card shadow-sm">
        <div class="position-relative">
          <a href="{{ asset($crop->crop_image) }}" class="glightbox" data-gallery="crop-gallery">
            <img id="mainImage" src="{{ asset($crop->crop_image ?: 'final_eagri/img/placeholder.jpg') }}" class="img-fluid w-100 rounded-top" alt="{{ $crop->crop_name }}" loading="lazy" style="object-fit:cover; height:460px;">
          </a>
        </div>

        <div class="d-flex gap-2 p-3 gallery-thumb">
          @if($crop->crop_image)<img src="{{ asset($crop->crop_image) }}" alt="image1" class="rounded border" data-src="{{ asset($crop->crop_image) }}" loading="lazy">@endif
          @if($crop->crop_image2)<img src="{{ asset($crop->crop_image2) }}" alt="image2" class="rounded border" data-src="{{ asset($crop->crop_image2) }}" loading="lazy">@endif
          {{-- Add more images if available --}}
        </div>
      </div>
    </div>

    <!-- Info & Bidding -->
    <div class="col-lg-6">
      <div class="card border-success shadow-sm rounded-4 p-4">
        <div class="d-flex justify-content-between">
          <h2 class="text-primary fw-bold">{{ $crop->crop_name }}</h2>
          <div class="text-end">
            <div class="small text-muted">Posted: {{ $crop->created_at->format('d M, Y') }}</div>
            @if(!Carbon::now()->greaterThan($crop->last_date_bidding))
              <div class="badge badge-open mt-1">Bidding Open</div>
            @else
              <div class="badge bg-secondary mt-1">Closed</div>
            @endif
          </div>
        </div>

        <ul class="list-unstyled mb-3 small">
          <li><strong>Quantity:</strong> {{ $crop->crop_quantity }}</li>
          <li><strong>Location:</strong> {{ $crop->crop_location }}</li>
          <li><strong>Base Bid:</strong> <span class="fw-semibold">{{ $crop->bid_rate }} TK</span></li>
          <li><strong>Last bid date:</strong> {{ $crop->last_date_bidding }}</li>
          <li><strong>Condition:</strong> {{ ucfirst($crop->condition) }}</li>
        </ul>

        <p class="mb-1">{{ $crop->crop_description }}</p>

        <div class="row mt-4 g-2">
          <div class="col-sm-6">
            @if(Session::get('c_username') && !Carbon::now()->greaterThan($crop->last_date_bidding))
              <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#BidModal">🌾 Place Bid</button>
            @elseif(!Session::get('c_username'))
              <a href="{{ route('login') }}" class="btn btn-outline-success w-100">Login to Bid</a>
            @else
              <div class="alert alert-danger text-center">Bidding has finished.</div>
            @endif
          </div>
          <div class="col-sm-6">
            <a href="https://wa.me/8801625738164?text={{ urlencode('Hi, I\'m interested in ' . $crop->crop_name) }}" target="_blank" class="btn btn-outline-success w-100"><i class="fab fa-whatsapp me-2"></i>Contact Farmer</a>
          </div>
        </div>

        <div class="mt-4">
          <h6 class="small text-muted mb-2">Farmer</h6>
          @php($details = App\Models\farmer_register::where('username', $crop->username)->first())
          <div class="d-flex gap-3 align-items-center">
            <img src="{{ asset($details->profile_photo ?? 'final_eagri/img/agri.png') }}" alt="{{ $details->username }}" class="seller-card">
            <div>
              <div class="fw-semibold">{{ $crop->username }}</div>
              <div class="small text-muted">{{ $details->division ?? '—' }}</div>
            </div>
            <div class="ms-auto small text-muted">Member since {{ optional($details->created_at)->format('Y') }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Active Bids -->
  <div class="row mt-4">
    <div class="col-lg-8">
      <h5 class="fw-bold mb-3">Active Bids</h5>

      @forelse($bids_msg as $bid)
        <div class="card mb-3 shadow-sm">
          <div class="card-body d-flex justify-content-between align-items-start">
            <div>
              <div class="fw-semibold">👤 {{ $bid->cust_username }}</div>
              <div class="small text-muted">{{ $bid->message }}</div>
            </div>
            <div class="text-end">
              <div class="fw-bold">{{ $bid->bid_price }} TK</div>
              <div class="small text-muted">{{ $bid->created_at->diffForHumans() }}</div>
              <div class="mt-2 d-flex gap-2">
                @if($bid->cust_username == Session::get('c_username') && !Carbon::now()->greaterThan($crop->last_date_bidding))
                  <a href="{{ route('bid_delete', ['id'=>$bid->id,'crop_id'=>$bid->crop_id]) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete bid?')">Delete</a>
                @endif
                @if($crop->username == Session::get('f_username'))
                  <a href="{{ route('confirm_form', ['id'=>$bid->id]) }}" target="_blank" class="btn btn-success btn-sm">Confirm</a>
                @endif
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="text-muted">No bids yet. Be the first to bid!</div>
      @endforelse
    </div>

    <aside class="col-lg-4">
      <div class="card shadow-sm p-3">
        <h6 class="fw-bold">Best Bid</h6>
        @php($best = App\Models\Bid_message::where('crop_id', $crop->id)->max('bid_price'))
        <div class="display-6 fw-semibold">{{ $best ? $best . ' TK' : 'No bids yet' }}</div>
      </div>

      <div class="card shadow-sm mt-3 p-3">
        <h6 class="fw-bold">Related Crops</h6>
        <div class="list-group">
          @foreach(App\Models\crop_import::where('crop_type', $crop->crop_type)->where('id','<>',$crop->id)->take(4)->get() as $rel)
            <a href="{{ route('crop_details', ['id'=>$rel->id]) }}" class="list-group-item list-group-item-action">
              <div class="d-flex align-items-center gap-2">
                <img src="{{ asset($rel->crop_image) }}" width="64" height="48" style="object-fit:cover;" alt="{{ $rel->crop_name }}">
                <div>
                  <div class="small fw-semibold">{{ Str::limit($rel->crop_name, 36) }}</div>
                  <div class="small text-muted">{{ $rel->bid_rate }} TK</div>
                </div>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </aside>
  </div>
</div>

<!-- Farmer modal and Bid modal -->
<!-- Bid Modal -->
<div class="modal fade" id="BidModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-success shadow-lg rounded-4">
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

          @php($price = App\Models\Bid_message::where('crop_id', $crop->id)->max('bid_price'))
          <div class="mb-2 small text-muted"><strong>Base:</strong> {{ $crop->bid_rate }} TK</div>
          <div class="mb-3 small text-muted"><strong>Best Bid:</strong> {{ $price ? $price.' TK' : 'No bids yet' }}</div>

          <div class="mb-3">
            <label class="form-label">Your Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Bid Price (TK)</label>
            <input id="bid-price" type="number" name="bid_price" class="form-control" placeholder="Enter your bid" min="{{ $price ?? $crop->bid_rate }}" value="{{ max($price ?? $crop->bid_rate, $crop->bid_rate) }}" required>
            <div class="form-text">Must be at least {{ $price ?? $crop->bid_rate }} TK</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Message (optional)</label>
            <textarea name="message" class="form-control" rows="2" placeholder="Enter a message"></textarea>
          </div>

          <button type="submit" id="submit-bid" class="btn btn-success w-100">Submit Bid</button>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // small gallery thumbnail switch
  document.querySelectorAll('.gallery-thumb img').forEach(img => {
    img.addEventListener('click', () => {
      const src = img.dataset.src || img.src;
      document.getElementById('mainImage').src = src;
    });
  });

  // client-side validation for bid price (prevent sending lower)
  document.getElementById('bid-form')?.addEventListener('submit', function(e){
    const min = parseFloat(document.getElementById('bid-price').min || 0);
    const value = parseFloat(document.getElementById('bid-price').value || 0);
    if (value < min) {
      e.preventDefault();
      alert('Your bid must be at least ' + min + ' TK.');
      document.getElementById('bid-price').focus();
    }
  });

  // Initialize GLightbox if available (lightbox on main image)
  if (window.GLightbox) GLightbox({ selector: '.glightbox' });
</script>
@endpush
@endsection
