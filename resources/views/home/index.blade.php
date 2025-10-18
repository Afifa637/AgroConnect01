@extends('home.headerFooter')

@section('title', 'Home')

@push('head')
    <style>
        .hero-caption {
            max-width: 680px;
        }
        .favorite-btn {
            transition: transform 0.2s ease, color 0.2s ease;
        }
        .favorite-btn:hover {
            transform: scale(1.2);
            color: #dc3545 !important;
        }
        .market-card .card-body {
            min-height: 150px;
        }
    </style>
@endpush

@section('body')
    <div class="container">
        <!-- HERO / FEATURED CAROUSEL -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div id="heroCarousel" class="carousel slide shadow-sm rounded" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            // Use featured items if passed from controller
                            $heroItems = $featured ?? (isset($crops) ? $crops->take(4) : collect());
                        @endphp

                        @if ($heroItems && $heroItems->count())
                            @foreach ($heroItems as $k => $item)
                                <div class="carousel-item {{ $k == 0 ? 'active' : '' }} position-relative">
                                    <img src="{{ asset($item->crop_image ?? 'final_eagri/img/1.jpg') }}" class="d-block w-100"
                                        alt="{{ $item->crop_name }}" loading="lazy" style="height:420px; object-fit:cover;">
                                    <div class="carousel-caption d-none d-md-block hero-overlay p-4 rounded">
                                        <div class="hero-caption text-start">
                                            <h2 class="fw-bold text-white">{{ Str::limit($item->crop_name, 48) }}</h2>
                                            <p class="text-white small">{{ Str::limit($item->crop_description, 140) }}</p>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('crop_details', ['id' => $item->id]) }}"
                                                    class="btn btn-success btn-lg">View Crop</a>
                                                <a href="{{ route('signup') }}"
                                                    class="btn btn-outline-light btn-lg">Join</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- fallback static slides -->
                            <div class="carousel-item active">
                                <img src="{{ asset('final_eagri/img/1.jpg') }}" class="d-block w-100" alt="Slide 1"
                                    style="height:420px; object-fit:cover;">
                                <div class="carousel-caption d-none d-md-block hero-overlay rounded p-4">
                                    <h1 class="fw-bold text-white">Connecting Farmers & Buyers</h1>
                                    <p class="text-white">Bringing technology and trust to agriculture trade</p>
                                    <a href="{{ route('signup') }}" class="btn btn-success btn-lg">Join Now</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- Quick Actions / Highlights -->
            <div class="col-lg-4">
                <div class="card card-ghost shadow-sm h-100 p-3">
                    <h5 class="fw-bold">Quick Actions</h5>
                    <p class="small text-muted">Get started quickly — list crops, browse verified farmers and bid securely.
                    </p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('signup') }}" class="btn btn-success">Create Account</a>
                        <a href="{{ route('services') }}" class="btn btn-outline-success">How it Works</a>
                        <a href="{{ route('news_info') }}" class="btn btn-light border">Latest News</a>
                    </div>
                    <hr>
                    <div class="mt-2">
                        <h6 class="small text-muted">Verified Farmers</h6>
                        <div class="d-flex gap-2 mt-2">
                            @foreach (App\Models\farmer_register::inRandomOrder()->take(4)->get() as $f)
                                <a href="#" class="text-decoration-none text-dark" title="{{ $f->username }}">
                                    <img src="{{ asset($f->profile_photo ?? 'final_eagri/img/agri.png') }}" width="44"
                                        height="44" class="rounded-circle border" alt="{{ $f->username }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SERVICES / FEATURE ROW -->
        <section class="mb-5">
            <div class="container">
                <h3 class="fw-bold text-center mb-4">How AgroConnect Helps</h3>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm text-center p-4">
                            <i class="fas fa-seedling fa-3x text-success mb-3"></i>
                            <h5 class="fw-bold">Crop Marketplace</h5>
                            <p class="small text-muted">List produce with images and bidding tools.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm text-center p-4">
                            <i class="fas fa-hand-holding-heart fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Farmer Support</h5>
                            <p class="small text-muted">Guidance on pricing, listing and shipping.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm text-center p-4">
                            <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                            <h5 class="fw-bold">Secure Bids</h5>
                            <p class="small text-muted">Transparent bidding and confirmation flows.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- MARKETPLACE GRID -->
        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold">Latest Crops</h4>
                <a href="{{ route('categories', ['crop_type' => 0]) }}" class="small text-decoration-none">View All →</a>
            </div>

            <div class="row g-4">
                @forelse($crops as $crop)
                    <div class="col-md-4">
                        <div class="card crop-card shadow-sm">
                            <div class="position-relative">
                                <img src="{{ asset($crop->crop_image ?: 'final_eagri/img/placeholder.jpg') }}"
                                    class="card-img-top" alt="{{ $crop->crop_name }}" loading="lazy">
                                <div class="position-absolute top-0 end-0 m-2">
                                    @if (Session::has('c_username'))
                                        <form action="{{ route('wishlist_db', ['id' => $crop->id]) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit"
                                                class="favorite-btn border-0 bg-transparent text-danger"
                                                title="Add to wishlist">
                                                <i class="far fa-heart fa-lg"></i>
                                            </button>
                                        </form>
                                    @else
                                        {{-- Guest: hide or show disabled heart --}}
                                        <button type="button"
                                            class="favorite-btn border-0 bg-transparent text-secondary opacity-50"
                                            title="Login to add to wishlist" disabled>
                                            <i class="far fa-heart fa-lg"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <h6 class="fw-bold">{{ Str::limit($crop->crop_name, 48) }}</h6>
                                <p class="small text-muted mb-2">{{ Str::limit($crop->crop_description, 90) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="small text-muted">From: {{ $crop->crop_location }}</div>
                                        <div class="fw-semibold">{{ $crop->bid_rate }} TK</div>
                                    </div>
                                    <div class="text-end">
                                        <a href="{{ route('crop_details', ['id' => $crop->id]) }}"
                                            class="btn btn-outline-success btn-sm">Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer small text-muted d-flex justify-content-between">
                                <div>Posted: {{ $crop->created_at->diffForHumans() }}</div>
                                <div>{{ $crop->condition == 'old' ? 'Completed' : 'Open' }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">No crops found.</div>
                @endforelse
            </div>

            <!-- pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $crops->links('pagination::bootstrap-5') }}
            </div>
        </section>

        <!-- STATISTICS (COUNTERS) -->
        <section class="py-5 mb-5 rounded"
            style="background:url('{{ asset('final_eagri/img/crop.jpg') }}') center/cover no-repeat fixed;">
            <div class="container text-white text-center py-5" style="background:rgba(0,0,0,0.35); border-radius:8px;">
                <div class="row">
                    <div class="col-md-3">
                        <h2 class="fw-bold counter" data-target="{{ (int) ($farmersCount ?? 0) }}">
                            {{ number_format((int) ($farmersCount ?? 0)) }}</h2>
                        <div>Farmers Registered</div>
                    </div>

                    <div class="col-md-3">
                        <h2 class="fw-bold counter" data-target="{{ (int) ($cropsCount ?? 0) }}">
                            {{ number_format((int) ($cropsCount ?? 0)) }}</h2>
                        <div>Crops Listed</div>
                    </div>

                    <div class="col-md-3">
                        <h2 class="fw-bold counter" data-target="{{ (int) ($buyersCount ?? 0) }}">
                            {{ number_format((int) ($buyersCount ?? 0)) }}</h2>
                        <div>Verified Buyers</div>
                    </div>

                    <div class="col-md-3">
                        <h2 class="fw-bold counter" data-target="{{ (int) ($categoriesCount ?? 0) }}">
                            {{ number_format((int) ($categoriesCount ?? 0)) }}</h2>
                        <div>Categories</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- LATEST NEWS -->
        <section class="mb-5">
            <h4 class="fw-bold mb-3">Latest News</h4>
            <div class="row g-3">
                @foreach ($latestNews as $news)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img loading="lazy" src="{{ asset($news->news_image) }}" class="card-img-top"
                                alt="{{ $news->news_name }}">
                            <div class="card-body">
                                <h6 class="fw-bold">{{ Str::limit($news->news_name, 60) }}</h6>
                                <p class="small text-muted">{{ Str::limit($news->news_description, 100) }}</p>
                                <a href="{{ route('news_info') }}" class="btn btn-outline-success btn-sm">Read more</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- TESTIMONIALS -->
        <section class="mb-5">
            <h4 class="fw-bold text-center mb-4">What Farmers Say</h4>
            <div id="testimonials" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="card shadow-sm p-4">
                            <p class="text-muted">"AgroConnect helped me sell directly to buyers, no middlemen, better
                                profits!"</p>
                            <div class="fw-bold mt-2">— Abdul, Farmer</div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card shadow-sm p-4">
                            <p class="text-muted">"The platform is easy to use and transparent. I trust AgroConnect."</p>
                            <div class="fw-bold mt-2">— Rafiq, Buyer</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const counters = Array.from(document.querySelectorAll('.counter'));
                if (!counters.length) return;

                // Helper to animate a single counter element from 0 -> target
                const animateCounter = (el) => {
                    const target = parseInt(el.getAttribute('data-target') || '0', 10);
                    if (!Number.isFinite(target) || target <= 0) {
                        // If target is zero or invalid, ensure visible content is 0
                        el.innerText = (target === 0) ? '0' : el.innerText;
                        return;
                    }

                    // Start from 0 in DOM for animation clarity
                    let start = 0;
                    el.innerText = '0';

                    // Determine step and duration (make shorter for small numbers)
                    const duration = 1200; // total animation duration in ms
                    const frameRate = 60;
                    const totalFrames = Math.round((duration / 1000) * frameRate);
                    const increment = Math.max(1, Math.floor(target / totalFrames));

                    let current = 0;
                    const tick = () => {
                        current += increment;
                        if (current < target) {
                            el.innerText = current.toLocaleString();
                            requestAnimationFrame(tick);
                        } else {
                            el.innerText = target.toLocaleString();
                        }
                    };
                    requestAnimationFrame(tick);
                };

                // IntersectionObserver: animate each counter when visible (once)
                const io = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            animateCounter(entry.target);
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.25
                });

                // Observe each counter
                counters.forEach(c => io.observe(c));

                // ALSO: if any counters are already in view (no scrolling), start them immediately
                // (useful for short pages or when counters are near top)
                counters.forEach(c => {
                    const rect = c.getBoundingClientRect();
                    if (rect.top >= 0 && rect.top < window.innerHeight) {
                        // If still observed, we trigger animation manually
                        // (IntersectionObserver callback might not fire if element already intersected)
                        if (c.getAttribute('data-target')) {
                            animateCounter(c);
                            try {
                                io.unobserve(c);
                            } catch (e) {
                                /* ignore */
                            }
                        }
                    }
                });
            });

            // Wishlist button placeholder (AJAX hook)
            document.addEventListener('click', (e) => {
                const fav = e.target.closest('.favorite-btn');
                if (!fav) return;
                e.preventDefault();

                const id = fav.dataset.id;
                if (!id) return;

                // If user must be logged in, your controller will handle redirect to login.
                // This is simple and safe because it uses your existing route definitions.
                window.location.href = '{{ url('/customer/wishlist/save') }}/' + encodeURIComponent(id);
            });
        </script>
    @endpush
@endsection
