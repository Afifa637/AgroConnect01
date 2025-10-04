<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AgroConnect - Buyer')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom Theme -->
    <link href="{{ asset('css/agro-theme.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <!-- 🌿 Top Navbar -->
    <nav class="navbar navbar-expand-lg bg-light shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-success d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ url('final_eagri/img/agri.png') }}" height="40" class="me-2">
                AgroConnect
            </a>

            <button class="navbar-toggler border-success" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <form action="{{ route('search') }}" method="get" class="d-flex mx-auto w-50">
                    @csrf
                    <input class="form-control me-2 border-success" name="search" placeholder="Search crops..." type="search">
                    <button class="btn btn-success" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <div class="d-flex align-items-center">
                    @if(Session::get('c_username'))
                        <a href="{{ route('wishlist',['c_username'=>Session::get('c_username')]) }}" class="btn btn-outline-success me-2">
                            <i class="bi bi-heart"></i>
                        </a>
                    @endif
                    @if(!Session::get('c_username'))
                        <a href="{{ route('login') }}" class="btn btn-outline-success me-2">Login</a>
                        <a href="{{ route('signup') }}" class="btn btn-success">Signup</a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ Session::get('c_username') }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('cust_profile',['c_username'=>Session()->get('c_username')]) }}"><i class="bi bi-person"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('c_message') }}"><i class="bi bi-chat-dots"></i> Confirm Buy</a></li>
                                <li><a class="dropdown-item" href="{{ route('cust_order_messages') }}"><i class="bi bi-bag-check"></i> Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('c_settings') }}"><i class="bi bi-gear"></i> Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('logout',['name'=>'c_username']) }}"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- 🌾 Secondary Menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container">
            <ul class="navbar-nav mx-auto text-uppercase fw-semibold">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link px-3">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3" href="#" role="button" data-bs-toggle="dropdown">Summer Crops</a>
                    <ul class="dropdown-menu">
                        @php($categories=App\Models\categories_info::where('categories_status',1)->get())
                        @foreach($categories as $categorie)
                            <li><a class="dropdown-item" href="{{ route('Session_Categories',['crop_type'=>$categorie->id,'crop_session'=>1]) }}">{{ $categorie->categories_name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3" href="#" data-bs-toggle="dropdown">Winter Crops</a>
                    <ul class="dropdown-menu">
                        @foreach($categories as $categorie)
                            <li><a class="dropdown-item" href="{{ route('Session_Categories',['crop_type'=>$categorie->id,'crop_session'=>2]) }}">{{ $categorie->categories_name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3" href="#" data-bs-toggle="dropdown">Monsoon Crops</a>
                    <ul class="dropdown-menu">
                        @foreach($categories as $categorie)
                            <li><a class="dropdown-item" href="{{ route('Session_Categories',['crop_type'=>$categorie->id,'crop_session'=>3]) }}">{{ $categorie->categories_name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item"><a href="{{ route('about') }}" class="nav-link px-3">About</a></li>
                <li class="nav-item"><a href="{{ route('services') }}" class="nav-link px-3">Services</a></li>
                <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link px-3">Contact</a></li>
                <li class="nav-item"><a href="{{ route('gallery') }}" class="nav-link px-3">Gallery</a></li>
            </ul>
        </div>
    </nav>

    <!-- 🌱 Page Content -->
    <div class="container-fluid my-5 px-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 mb-4">
                <div class="card shadow-sm border-success">
                    <div class="card-header bg-success text-white text-center fw-bold">Categories</div>
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $categorie)
                            <li class="list-group-item">
                                <a href="{{ route('Categories',['crop_type'=>$categorie->id]) }}" class="text-success fw-semibold text-decoration-none">
                                    {{ $categorie->categories_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Main -->
            <div class="col-lg-10">
                <h4 class="text-success text-center">{{ Session::get('bid_success') }}</h4>
                @yield('body')
            </div>
        </div>
    </div>

    <!-- 🌾 Footer -->
    <footer class="agro-footer text-white py-5">
        <div class="container">
            <div class="row g-4 text-center text-md-start">
                <div class="col-md-3">
                    <h5>About AgroConnect</h5>
                    <p>Connecting farmers and buyers with trust and transparency. Fresh crops, fair prices, sustainable trade.</p>
                    <div>
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-github"></i></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('news_info') }}" class="text-white text-decoration-none">News</a></li>
                        <li><a href="{{ route('gallery') }}" class="text-white text-decoration-none">Gallery</a></li>
                        <li><a href="{{ route('services') }}" class="text-white text-decoration-none">Services</a></li>
                        <li><a href="{{ route('contact') }}" class="text-white text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Customer Support</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white text-decoration-none">Help Center</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Feedback</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Live Chat</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact Info</h5>
                    <p><i class="bi bi-geo-alt"></i> House #100, Uttara, Dhaka</p>
                    <p><i class="bi bi-envelope"></i> eagriculture@gmail.com</p>
                    <p><i class="bi bi-telephone"></i> +8801989419776</p>
                </div>
            </div>
            <hr class="border-light">
            <p class="text-center mb-0">© {{ date('Y') }} AgroConnect | Harvested Fresh, Delivered Straight to You 🌿</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
