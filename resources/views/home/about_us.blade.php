@extends('home.headerFooter')

@section('title', 'About Us')

@section('body')

<!-- Hero Section -->
<section id="page-header" class="d-flex align-items-center text-white"
    style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
           url('{{ url('final_eagri/img/a.jpg')}}') center/cover no-repeat; height: 250px;">
    <div class="container text-center">
        <h1 class="fw-bold display-5">About Us</h1>
        <p class="lead">Who We Are and What We Do</p>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <h2 class="fw-bold text-success mb-3">Our Mission</h2>
                <p class="lead text-muted">
                    To provide technology and services to farmers, helping them expand their business and connect with
                    a wider market. We aim to improve farming processes and spread knowledge about recent agriculture
                    issues.
                </p>
                <h2 class="fw-bold text-primary mt-4 mb-3">Our Vision</h2>
                <p class="lead text-muted">
                    To lend a helping hand to farmers and customers, improving their lives through technology, and
                    strengthening the agriculture sector within Bangladesh's economy.
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
        <div class="row g-4 align-items-center">
            <div class="col-lg-6 text-center">
                <img src="{{ url('final_eagri/img/service.jpg')}}" class="img-fluid rounded-3 shadow-lg" alt="Service">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold text-dark mb-3">About E-Agriculture</h2>
                <p class="lead text-muted">
                    Our web platform empowers farmers by giving them direct access to buyers, ensuring fair profits and
                    eliminating middlemen. Farmers can register, post their products, and sell easily. Buyers can bid on
                    listed items across multiple categories, making agriculture accessible and transparent.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Features / Icon Boxes -->
<section id="icon-boxes" class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow border-0 text-center">
                    <div class="card-body p-4">
                        <div class="icon mb-3 text-success fs-1">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <h4 class="fw-bold">Website</h4>
                        <p class="text-muted">
                            Our online auction system removes intermediaries, making the market fairer for both farmers
                            and buyers.
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
                        <h4 class="fw-bold">Farmer</h4>
                        <p class="text-muted">
                            Farmers gain freedom to set their own prices, transforming agriculture into a profitable
                            sector.
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
                        <h4 class="fw-bold">Buyer</h4>
                        <p class="text-muted">
                            Buyers and wholesalers can easily access products directly from farmers, ensuring quality and
                            fair deals.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
