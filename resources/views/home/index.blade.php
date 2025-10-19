@extends('home.headerFooter')

@section('title', 'Home')

@push('head')
<style>
    /* General look */
    body {
        background-color: #f8fdf8;
    }

    .hero-caption {
        background: rgba(0, 0, 0, 0.45);
        border-radius: 12px;
        padding: 20px;
        max-width: 550px;
    }

    .section-title {
        font-weight: 700;
        text-align: center;
        color: #2e7d32;
        margin-bottom: 1.5rem;
    }

    .category-list a {
        text-decoration: none;
        color: #2e7d32;
        font-weight: 600;
    }

    .category-list a:hover {
        color: #1b5e20;
        text-decoration: underline;
    }

    .category-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .category-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
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
<div class="container-fluid p-0">
    <!-- 🌾 INTRO SECTION -->
    <div class="row align-items-stretch mb-4 g-3">
        <div class="col-lg-8 col-md-12">
            <div id="heroCarousel" class="carousel slide shadow-lg rounded" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @php
                        $slides = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '33.jpg'];
                    @endphp
                    @foreach($slides as $index => $img)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img src="{{ asset('final_eagri/img/' . $img) }}" class="d-block w-100 rounded"
                                 style="height:480px; object-fit:cover;" alt="AgroConnect Agriculture Image">
                            <div class="carousel-caption d-none d-md-block text-start">
                                <div class="hero-caption">
                                    <h2 class="fw-bold text-white">Empowering Agriculture</h2>
                                    <p class="text-white small mb-3">Connecting farmers, buyers & technology — one harvest at a time.</p>
                                    <div class="d-flex gap-2">
                                        <a href="#latest_crops" class="btn btn-success btn-lg">
                                            Explore Marketplace
                                        </a>
                                        <a href="{{ route('signup') }}" class="btn btn-outline-light btn-lg">
                                            Join AgroConnect
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- 🌾 SERVICES SECTION -->
    <section class="mb-5">
        <h3 class="section-title">How AgroConnect Helps</h3>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm text-center p-4">
                    <i class="fas fa-seedling fa-3x text-success mb-3"></i>
                    <h5 class="fw-bold">Crop Marketplace</h5>
                    <p class="small text-muted">List your produce easily and connect directly with buyers.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm text-center p-4">
                    <i class="fas fa-tractor fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">Farmer Empowerment</h5>
                    <p class="small text-muted">Tools and support to help you grow, sell, and profit sustainably.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm text-center p-4">
                    <i class="fas fa-handshake fa-3x text-warning mb-3"></i>
                    <h5 class="fw-bold">Secure Bidding</h5>
                    <p class="small text-muted">Transparent and fair bidding system with trusted confirmations.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 🌽 LATEST CROPS -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-success" id="latest_crops">Latest Crops</h4>
            <a href="{{ route('categories', ['crop_type' => 1]) }}" class="small text-decoration-none">View All →</a>
        </div>

        <div class="row g-4">
            @foreach($crops->take(6) as $crop)
                <div class="col-md-4">
                    <div class="card crop-card shadow-sm border-success border-opacity-25">
                        <div class="position-relative">
                            <img src="{{ asset($crop->crop_image ?: 'final_eagri/img/placeholder.jpg') }}"
                                 class="card-img-top" alt="{{ $crop->crop_name }}" loading="lazy">
                            <div class="position-absolute top-0 end-0 m-2">
                                @if (Session::has('c_username'))
                                    <form action="{{ route('wishlist_db', ['id' => $crop->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="favorite-btn border-0 bg-transparent text-danger" title="Add to wishlist">
                                            <i class="far fa-heart fa-lg"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button" class="favorite-btn border-0 bg-transparent text-secondary opacity-50" title="Login to add to wishlist" disabled>
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
                                    <div class="fw-semibold text-success">{{ $crop->bid_rate }} TK</div>
                                </div>
                                <a href="{{ route('crop_details', ['id' => $crop->id]) }}" class="btn btn-outline-success btn-sm">Details</a>
                            </div>
                        </div>
                        <div class="card-footer small text-muted d-flex justify-content-between">
                            <div>Posted: {{ $crop->created_at->diffForHumans() }}</div>
                            <div>{{ $crop->condition == 'old' ? 'Closed' : 'Open' }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
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
                const animateCounter = (el) => {
                    const target = parseInt(el.getAttribute('data-target') || '0', 10);
                    if (!Number.isFinite(target) || target <= 0) {
                        el.innerText = (target === 0) ? '0' : el.innerText;
                        return;
                    }

                    let start = 0;
                    el.innerText = '0';
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

                counters.forEach(c => io.observe(c));
                counters.forEach(c => {
                    const rect = c.getBoundingClientRect();
                    if (rect.top >= 0 && rect.top < window.innerHeight) {
                        if (c.getAttribute('data-target')) {
                            animateCounter(c);
                            try {
                                io.unobserve(c);
                            } catch (e) {
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
