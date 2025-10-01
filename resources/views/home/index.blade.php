@extends('home.headerFooter')

@section('title', 'Home')

@section('body')

<!-- Carousel -->
<div id="carouselExampleIndicators" class="carousel slide my-4" data-bs-ride="carousel">
    <div class="carousel-inner rounded shadow-lg">
        <div class="carousel-item active">
            <img src="{{ asset('final_eagri/img/1.jpg') }}" class="d-block w-100" alt="Slide 1">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('final_eagri/img/2.jpg') }}" class="d-block w-100" alt="Slide 2">
        </div>
        <div class="carousel-item">
            <img src="{{ asset('final_eagri/img/3.jpg') }}" class="d-block w-100" alt="Slide 3">
        </div>
    </div>
</div>

<!-- Info Section -->
<section class="py-5 text-center bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <i class="fas fa-user-plus fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">Register</h5>
                        <p>Create an account by registering your contact details.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <i class="fas fa-lock-open fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">Login</h5>
                        <p>Login to your account to buy or sell agricultural products.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <i class="fas fa-seedling fa-3x text-warning mb-3"></i>
                        <h5 class="fw-bold">Sell Products</h5>
                        <p>Farmers can sell crops online anywhere, anytime.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart fa-3x text-danger mb-3"></i>
                        <h5 class="fw-bold">Buy Products</h5>
                        <p>Buyers can buy products online by bidding securely.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
