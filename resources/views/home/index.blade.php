@extends('home.headerFooter')

@section('title', 'Home')

@section('body')

<!-- Carousel -->
<div id="carouselExampleIndicators" class="carousel slide my-3" data-bs-ride="carousel">
    <div class="carousel-inner">
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
<section class="py-4 text-center">
    <div class="row g-3">
        <div class="col-md-3"><div class="card shadow-sm"><div class="card-body">
            <i class="fas fa-user-circle fa-3x mb-3"></i>
            <h5>Register</h5>
            <p>Create an account by registering your contact details.</p>
        </div></div></div>

        <div class="col-md-3"><div class="card shadow-sm"><div class="card-body">
            <i class="fas fa-lock-open fa-3x mb-3"></i>
            <h5>Login</h5>
            <p>Login to your account to buy or sell agricultural products.</p>
        </div></div></div>

        <div class="col-md-3"><div class="card shadow-sm"><div class="card-body">
            <i class="fas fa-list-ul fa-3x mb-3"></i>
            <h5>Sell Products</h5>
            <p>Farmers can sell crops online anywhere, anytime.</p>
        </div></div></div>

        <div class="col-md-3"><div class="card shadow-sm"><div class="card-body">
            <i class="fas fa-shopping-cart fa-3x mb-3"></i>
            <h5>Buy Products</h5>
            <p>Buyers can buy products online by bidding.</p>
        </div></div></div>
    </div>
</section>

@endsection
