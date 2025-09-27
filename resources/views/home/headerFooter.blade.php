<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AgroConnect')</title>

    <!-- Bootstrap 5 (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (CDN) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('final_eagri/css/home-style.css') }}" rel="stylesheet">
</head>
<body style="font-size: 18px; font-family: 'Fredericka the Great', cursive;">

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light py-2">
    <a class="navbar-brand ms-4" href="{{ route('home') }}">
        <img src="{{ asset('final_eagri/img/agri.png') }}" alt="AgroConnect Logo" height="40">
    </a>
</nav>

<!-- Main Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('gallery') }}">Photo Gallery</a></li>
        </ul>
    </div>
</nav>

<!-- Content -->
<div class="container-fluid mt-5 pt-4">
    @yield('body')
</div>

<!-- Footer -->
<footer class="py-5 bg-dark text-white mt-5">
    <div class="row text-center">
        <div class="col-lg-3">
            <h5>About AgroConnect</h5>
            <p class="small">Connecting farmers and buyers directly with trust and transparency.</p>
        </div>
        <div class="col-lg-3">
            <h5>Quick Links</h5>
            <a class="d-block text-light" href="{{ route('about') }}">About</a>
            <a class="d-block text-light" href="{{ route('services') }}">Services</a>
            <a class="d-block text-light" href="{{ route('contact') }}">Contact</a>
        </div>
        <div class="col-lg-3">
            <h5>Services</h5>
            <p>Crop Marketplace</p>
            <p>Farmer Support</p>
            <p>Buyer Assistance</p>
        </div>
        <div class="col-lg-3">
            <h5>Contact</h5>
            <p>Email: agroconnect@gmail.com</p>
            <p>Phone: +8801XXXXXXX</p>
        </div>
    </div>
    <p class="text-center mt-3 mb-0 small">&copy; {{ now()->year }} AgroConnect</p>
</footer>

<!-- Bootstrap Bundle with Popper (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
