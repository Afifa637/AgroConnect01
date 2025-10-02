<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AgroConnect')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Custom styles -->
    <link href="{{ asset('final_eagri/css/home-style.css') }}" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        :target {
            scroll-margin-top: 110px;
        }

        /* offset for fixed nav */
        body {
            font-size: 17px;
            font-family: "Poppins", sans-serif;
            background: #f7fafc;
        }

        .navbar {
            transition: all 0.3s ease-in-out;
        }

        .navbar-brand img {
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .nav-link {
            font-weight: 500;
        }

        .nav-link:hover {
            color: #28a745 !important;
        }

        .list-group-item:hover {
            background: #28a745;
            color: #fff;
        }

        footer {
            background: #1a1a1a;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>

    <!-- ✅ Single Top Navbar with Search -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('final_eagri/img/logo.png') }}" alt="AgroConnect Logo" height="40">
            </a>

            <!-- Search Bar -->
            <form class="d-flex mx-auto" action="{{ route('search') }}" method="get">
                <input class="form-control me-2 rounded-pill shadow-sm" type="search" name="search"
                    placeholder="Search crops..." aria-label="Search" style="min-width: 300px;">
                <button class="btn btn-success rounded-pill px-4" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <!-- Auth Buttons -->
            <div>
                @if (Session::get('c_username'))
                    <a class="btn btn-outline-success me-2 rounded-pill"
                        href="{{ route('wishlist', ['c_username' => Session::get('c_username')]) }}">
                        <i class="far fa-heart"></i>
                    </a>
                    <div class="btn-group">
                        <button class="btn btn-success dropdown-toggle rounded-pill" data-bs-toggle="dropdown">
                            <i class="fa fa-user"></i> {{ Session::get('c_username') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item"
                                    href="{{ route('cust_profile', ['c_username' => Session::get('c_username')]) }}">
                                    <i class="fa fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('c_message') }}"><i class="fas fa-comment"></i>
                                    Confirm Buy</a></li>
                            <li><a class="dropdown-item" href="{{ route('cust_order_messages') }}"><i
                                        class="fas fa-box"></i> Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('c_settings') }}"><i
                                        class="fas fa-user-cog"></i> Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger"
                                    href="{{ route('logout', ['name' => 'c_username']) }}"
                                    onclick="return confirm('Are you sure you want to logout?');">
                                    <i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-success me-2 rounded-pill">Login</a>
                    <a href="{{ route('signup') }}" class="btn btn-success rounded-pill">Signup</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- secondary nav -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mt-5 pt-3 shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('services') }}#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}#contact">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('gallery') }}">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('news_info') }}">News</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Products</a>
                        <ul class="dropdown-menu">
                            @foreach (App\Models\categories_info::where('categories_status', 1)->get() as $categorie)
                                <li><a class="dropdown-item"
                                        href="{{ route('Session_Categories', ['crop_type' => $categorie->id, 'crop_session' => 1]) }}">{{ $categorie->categories_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ✅ Layout -->
    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Sidebar -->
            <aside class="col-lg-2 mb-4">
                <h5 class="mt-4">Categories</h5>
                <div class="list-group shadow-sm">
                    @foreach (App\Models\categories_info::where('categories_status', 1)->get() as $categorie)
                        <a href="{{ route('Categories', ['crop_type' => $categorie->id]) }}"
                            class="list-group-item list-group-item-action">
                            {{ $categorie->categories_name }}
                        </a>
                    @endforeach
                </div>
            </aside>

            <!-- Main Content -->
            <main class="col-lg-10">
                <h4 class="text-success">{{ Session::get('bid_success') }}</h4>
                @yield('body')
            </main>
        </div>
    </div>

    <!-- ✅ Footer -->
    <footer class="py-5 text-light">
        <div class="container">
            <div class="row text-center text-md-start">
                <div class="col-lg-3 mb-3">
                    <h5>AgroConnect</h5>
                    <p class="small">We connect farmers and buyers directly with innovation and simplicity.</p>
                    <div>
                        <a href="#" class="me-3 text-primary"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="me-3 text-danger"><i class="fab fa-youtube fa-lg"></i></a>
                        <a href="#" class="me-3 text-warning"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-github fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 mb-3">
                    <h5>Quick Links</h5>
                    <a class="d-block text-light" href="{{ route('news_info') }}">News</a>
                    <a class="d-block text-light" href="{{ route('gallery') }}">Gallery</a>
                    <a class="d-block text-light" href="#">Summer Crops</a>
                    <a class="d-block text-light" href="#">Winter Crops</a>
                    <a class="d-block text-light" href="#">Monsoon Crops</a>
                </div>
                <div class="col-lg-3 mb-3">
                    <h5>Services</h5>
                    <a class="d-block text-light" href="{{ route('about') }}">About</a>
                    <a class="d-block text-light" href="{{ route('services') }}">Services</a>
                    <a class="d-block text-light" href="{{ route('contact') }}">Contact</a>
                </div>
                <div class="col-lg-3 mb-3">
                    <h5>Contact</h5>
                    <p>Email: agroconnect@gmail.com</p>
                    <p>Phone: +8801625738164</p>
                </div>
            </div>
            <p class="text-center mt-4 mb-0 small">&copy; {{ now()->year }} AgroConnect</p>
        </div>
    </footer>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
