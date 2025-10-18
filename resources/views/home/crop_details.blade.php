@extends('home.headerFooter')

@section('title', $crop->crop_name ?? 'Crop Details')

@push('head')
    <!-- Swiper for slideshow -->
    <link href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" rel="stylesheet" />
    <style>
        .swiper {
            width: 100%;
            height: 500px;
            border-radius: 15px;
            overflow: hidden;
        }

        .swiper-slide img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .gallery-thumb {
            margin-top: 10px;
        }

        .gallery-thumb img {
            height: 90px;
            width: 100px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 10px;
            transition: transform 0.2s ease;
        }

        .gallery-thumb img:hover {
            transform: scale(1.05);
        }

        .seller-card img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
        }

        .badge-open {
            background: #198754;
            color: white;
            padding: 0.4rem 0.6rem;
            border-radius: 0.3rem;
        }

        .info-list li {
            padding: 4px 0;
        }

        .bid-btn {
            font-size: 1.1rem;
            font-weight: 600;
            padding: 10px 0;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .bid-section {
            text-align: center;
            margin-top: 1.5rem;
        }

        .bid-section .btn {
            width: 80%;
            font-size: 1.1rem;
        }

        .modal-content {
            border-radius: 15px;
        }

        .related img {
            border-radius: 10px;
        }
    </style>
@endpush

@section('body')
    @php use Carbon\Carbon; @endphp

    <div class="container my-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-4">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('categories', ['crop_type' => $crop->crop_type]) }}">
                        {{ optional(App\Models\categories_info::find($crop->crop_type))->categories_name ?? 'Category' }}
                    </a>
                </li>
                <li class="breadcrumb-item active">{{ $crop->crop_name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <!-- Crop Image Slider -->
            <div class="col-lg-6">
                <div class="card shadow-sm p-3">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @if ($crop->crop_image)
                                <div class="swiper-slide"><img src="{{ asset($crop->crop_image) }}"
                                        alt="{{ $crop->crop_name }}"></div>
                            @endif
                            @if ($crop->crop_image2)
                                <div class="swiper-slide"><img src="{{ asset($crop->crop_image2) }}" alt="Image 2"></div>
                            @endif
                            @if ($crop->crop_image3)
                                <div class="swiper-slide"><img src="{{ asset($crop->crop_image3) }}" alt="Image 3"></div>
                            @endif
                        </div>
                    </div>

                    <!-- Thumbnail previews -->
                    <div class="d-flex gap-2 flex-wrap gallery-thumb mt-3">
                        @foreach (['crop_image', 'crop_image2', 'crop_image3'] as $img)
                            @if ($crop->$img)
                                <img src="{{ asset($crop->$img) }}" data-src="{{ asset($crop->$img) }}" alt="thumb">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Crop Info -->
            <div class="col-lg-6">
                <div class="card shadow-sm p-4 border-success">
                    <div class="d-flex justify-content-between align-items-start">
                        <h2 class="text-success fw-bold">{{ $crop->crop_name }}</h2>
                        <div class="text-end">
                            <small class="text-muted d-block">Posted {{ $crop->created_at->diffForHumans() }}</small>
                            @if (!Carbon::now()->greaterThan($crop->last_date_bidding))
                                <span class="badge-open mt-1">Bidding Open</span>
                            @else
                                <span class="badge bg-secondary mt-1">Closed</span>
                            @endif
                        </div>
                    </div>

                    <ul class="list-unstyled info-list mt-3 small">
                        <li><strong>Quantity:</strong> {{ $crop->crop_quantity }}</li>
                        <li><strong>Location:</strong> {{ $crop->crop_location }}</li>
                        <li><strong>Base Bid:</strong> <span class="fw-semibold">{{ $crop->bid_rate }} TK</span></li>
                        <li>
                            <strong>Last Bid Date:</strong>
                            {{ Carbon::parse($crop->last_date_bidding)->format('d M Y, h:i A') }}
                            <br>
                            @if (Carbon::now()->lessThan($crop->last_date_bidding))
                                <small class="text-muted">Ends in {{ Carbon::now()->diffForHumans($crop->last_date_bidding, true) }}</small>
                            @endif
                        </li>
                        <li><strong>Condition:</strong> {{ ucfirst($crop->condition) }}</li>
                    </ul>

                    <p class="mt-3">{{ $crop->crop_description }}</p>

                    <!-- Bid Button Centered -->
                    <div class="bid-section">
                        @if (Session::get('c_username') && !Carbon::now()->greaterThan($crop->last_date_bidding))
                            <button class="btn btn-success bid-btn" data-bs-toggle="modal"
                                data-bs-target="#BidModal">🌾 Place Bid</button>
                        @elseif(!Session::get('c_username'))
                            <a href="{{ route('login') }}" class="btn btn-outline-success bid-btn">Login to Bid</a>
                        @else
                            <div class="alert alert-danger text-center mt-2">Bidding has finished.</div>
                        @endif
                    </div>

                    <!-- Farmer Info -->
                    <div class="mt-4 border-top pt-3">
                        <h6 class="text-muted mb-2">Farmer</h6>
                        @php($details = App\Models\farmer_register::where('username', $crop->username)->first())
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset($details->profile_photo ?? 'final_eagri/img/agri.png') }}"
                                alt="{{ $details->username }}">
                            <div>
                                <div class="fw-semibold">{{ $crop->username }}</div>
                                <div class="small text-muted">{{ $details->division ?? '—' }}</div>
                            </div>
                            <div class="ms-auto small text-muted">
                                Member since {{ optional($details->created_at)->format('Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Bids & Related Crops -->
        <div class="row mt-5">
            <!-- Active Bids -->
            <div class="col-lg-8">
                <h5 class="fw-bold mb-3">Active Bids</h5>

                @forelse($bids_msg as $bid)
                    <div class="card mb-3 shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold">👤 {{ $bid->cust_username }}</div>
                                <div class="text-muted small">{{ $bid->message }}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-success">{{ $bid->bid_price }} TK</div>
                                <small class="text-muted">{{ $bid->created_at->diffForHumans() }}</small>
                                <div class="mt-2 d-flex gap-2 justify-content-end">
                                    @if ($bid->cust_username == Session::get('c_username') && !Carbon::now()->greaterThan($crop->last_date_bidding))
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
                    <h6 class="fw-bold">Best Bid</h6>
                    @php($best = App\Models\Bid_message::where('crop_id', $crop->id)->max('bid_price'))
                    <div class="display-6 fw-semibold text-success">{{ $best ? $best . ' TK' : 'No bids yet' }}</div>
                </div>

                <div class="card shadow-sm p-3 related">
                    <h6 class="fw-bold mb-3">Related Crops</h6>
                    @foreach (App\Models\CropImport::where('crop_type', $crop->crop_type)->where('id', '<>', $crop->id)->take(4)->get() as $rel)
                        <a href="{{ route('crop_details', ['id' => $rel->id]) }}"
                            class="list-group-item list-group-item-action border-0 mb-2 p-2 rounded shadow-sm">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset($rel->crop_image) }}" width="70" height="55"
                                    style="object-fit:cover;" alt="{{ $rel->crop_name }}">
                                <div>
                                    <div class="small fw-semibold">{{ Str::limit($rel->crop_name, 36) }}</div>
                                    <div class="small text-muted">{{ $rel->bid_rate }} TK</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
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

                        @php($price = App\Models\Bid_message::where('crop_id', $crop->id)->max('bid_price'))
                        <div class="mb-2 small text-muted"><strong>Base:</strong> {{ $crop->bid_rate }} TK</div>
                        <div class="mb-3 small text-muted"><strong>Best Bid:</strong> {{ $price ? $price . ' TK' : 'No bids yet' }}</div>

                        <div class="mb-3">
                            <label class="form-label">Your Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bid Price (TK)</label>
                            <input id="bid-price" type="number" name="bid_price" class="form-control"
                                min="{{ $price ?? $crop->bid_rate }}"
                                value="{{ max($price ?? $crop->bid_rate, $crop->bid_rate) }}" required>
                            <div class="form-text">Must be at least {{ $price ?? $crop->bid_rate }} TK</div>
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

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
        <script>
            // Swiper slideshow
            const swiper = new Swiper(".mySwiper", {
                loop: true,
                autoplay: {
                    delay: 10000, // 10s interval
                    disableOnInteraction: false,
                },
                effect: "fade",
                fadeEffect: {
                    crossFade: true
                },
            });

            // thumbnail click change
            document.querySelectorAll('.gallery-thumb img').forEach(img => {
                img.addEventListener('click', () => {
                    swiper.slideTo(Array.from(img.parentNode.children).indexOf(img) + 1);
                });
            });

            // Validate bid price
            document.getElementById('bid-form')?.addEventListener('submit', function(e) {
                const min = parseFloat(document.getElementById('bid-price').min || 0);
                const value = parseFloat(document.getElementById('bid-price').value || 0);
                if (value < min) {
                    e.preventDefault();
                    alert('Your bid must be at least ' + min + ' TK.');
                    document.getElementById('bid-price').focus();
                }
            });
        </script>
    @endpush
@endsection
