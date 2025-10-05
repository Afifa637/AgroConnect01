<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Farmer Panel - AgroConnect')</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link href="{{ url('final_eagri/css/farmer-style.css') }}" rel="stylesheet">
</head>
<body style="font-size: 18px; font-family: 'Poppins', sans-serif;">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
  <div class="container">
    <a class="navbar-brand" href="{{ route('f_home') }}">
      <img src="{{ url('final_eagri/img/agri.png') }}" height="40" alt="AgroConnect">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('f_home') ? 'active' : '' }}" href="{{ route('f_home') }}">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Crops</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('crop_import') }}">Import Crop</a></li>
            <li><a class="dropdown-item" href="{{ route('crop_manage') }}">Manage Crop</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link" href="{{ route('farm_bid_messages') }}">Bid Messages</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('confirm_crops') }}">Confirm Crops</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('farmer_orders') }}">Orders</a></li>
      </ul>

      <!-- Right side -->
      <ul class="navbar-nav">
        @if (session()->has('f_username'))
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
              <i class="fa fa-user"></i> {{ Session()->get('f_username') }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('fa_profile',['f_username'=>Session()->get('f_username')]) }}"><i class="fa fa-user"></i> Profile</a></li>
              <li><a class="dropdown-item" href="{{ route('f_settings') }}"><i class="fa fa-gear"></i> Settings</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('farmer.logout') }}" method="POST" onsubmit="return confirm('Logout?');">
                  @csrf
                  <button type="submit" class="dropdown-item text-danger">
                    <i class="fa fa-sign-out-alt"></i> Logout
                  </button>
                </form>
              </li>              
            </ul>
          </li>
        @endif
      </ul>

      <!-- Search -->
      <form action="{{ route('farmer.search') }}" method="GET" class="d-flex ms-3">
        @csrf
        <input class="form-control me-2" type="search" name="q" placeholder="Search crops...">
        <button class="btn btn-outline-success" type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
  </div>
</nav>

<!-- Page Content -->
<div class="container mt-5 pt-4">
  @yield('body')
</div>

<!-- Footer -->
<footer class="bg-dark text-light py-5 mt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <h5>AgroConnect</h5>
        <p class="small">At AgroConnect, we connect farmers and buyers with simplicity and innovation.</p>
      </div>
      <div class="col-md-3">
        <h5>Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="{{ route('gallery') }}" class="text-light">Gallery</a></li>
          <li><a href="{{ route('home') }}" class="text-light">Home</a></li>
          <li><a href="{{ route('about') }}" class="text-light">About</a></li>
          <li><a href="{{ route('contact') }}" class="text-light">Contact</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Follow Us</h5>
        <a href="#"><i class="fab fa-facebook fa-lg text-primary me-3"></i></a>
        <a href="#"><i class="fab fa-instagram fa-lg text-danger me-3"></i></a>
        <a href="#"><i class="fab fa-youtube fa-lg text-danger me-3"></i></a>
        <a href="#"><i class="fab fa-github fa-lg text-light"></i></a>
      </div>
      <div class="col-md-3">
        <h5>Contact</h5>
        <p class="mb-1">House #100, Uttara, Dhaka</p>
        <p class="mb-1">agroconnect@gmail.com</p>
        <p>+8801625738164</p>
      </div>
    </div>
    <hr>
    <p class="text-center mb-0">&copy; {{ date('Y') }} AgroConnect. All rights reserved.</p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
