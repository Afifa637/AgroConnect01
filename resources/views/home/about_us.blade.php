@extends('home.headerFooter')

@section('title', 'About Us')

@section('body')

<!-- Hero Section -->
<section id="page-header" class="d-flex align-items-center text-white"
    style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
           url('{{ url('final_eagri/img/a.jpg')}}') center/cover no-repeat; height: 300px;">
    <div class="container text-center">
        <h1 class="fw-bold display-4">About Us</h1>
        <p class="lead">🌾 Growing Together with Farmers & Buyers</p>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold text-success mb-3"><i class="fas fa-bullseye"></i> Our Mission</h2>
                <p class="lead text-muted">
                    We empower farmers with technology to connect with a wider market, expand their business,
                    and improve farming processes through innovation and knowledge-sharing.
                </p>
                <h2 class="fw-bold text-primary mt-4 mb-3"><i class="fas fa-eye"></i> Our Vision</h2>
                <p class="lead text-muted">
                    To strengthen Bangladesh’s agriculture economy by connecting farmers and customers,
                    making lives better with digital farming solutions.
                </p>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ url('final_eagri/img/crop.jpg')}}" class="img-fluid rounded-3 shadow-lg" alt="Crops">
            </div>
        </div>
    </div>
</section>

<!-- About E-Agriculture -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 text-center">
                <img src="{{ url('final_eagri/img/service.jpg')}}" class="img-fluid rounded-3 shadow-lg" alt="Service">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold text-dark mb-3"><i class="fas fa-leaf"></i> About E-Agriculture</h2>
                <p class="lead text-muted">
                    Our platform creates a transparent and fair marketplace where farmers directly connect with buyers,
                    ensuring quality products and fair pricing. Farmers can post crops, while buyers can bid easily.
                </p>
                <a href="{{ route('services') }}" class="btn btn-success rounded-pill px-4 mt-2">
                    Explore Services <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features / Icon Boxes -->
<section id="icon-boxes" class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-5">Why Choose Us?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow border-0 text-center">
                    <div class="card-body p-4">
                        <div class="icon mb-3 text-success fs-1">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <h4 class="fw-bold">Global Marketplace</h4>
                        <p class="text-muted">
                            Breaking barriers for farmers and buyers to connect beyond traditional systems.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow border-0 text-center">
                    <div class="card-body p-4">
                        <div class="icon mb-3 text-primary fs-1">
                            <i class="fa-solid fa-seedling"></i>
                        </div>
                        <h4 class="fw-bold">Empowering Farmers</h4>
                        <p class="text-muted">
                            Giving farmers freedom to set prices and maximize profits with transparency.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow border-0 text-center">
                    <div class="card-body p-4">
                        <div class="icon mb-3 text-danger fs-1">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>
                        <h4 class="fw-bold">Fair Buying</h4>
                        <p class="text-muted">
                            Buyers access trusted, quality products directly from farmers at fair deals.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
