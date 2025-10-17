<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AgroConnect')</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Custom Theme -->
    <style>
        :root {
            --agro-green: #198754;
            --agro-dark: #1b1f1a;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f7faf9;
            color: #2c2c2c;
        }
        .navbar {
            font-weight: 500;
        }
        .navbar-brand img {
            height: 42px;
        }
        .navbar-light .nav-link:hover {
            color: var(--agro-green) !important;
        }
        .btn-success {
            background: var(--agro-green);
            border: none;
        }
        .btn-outline-success:hover {
            background: var(--agro-green);
            color: #fff;
        }
        footer {
            background: var(--agro-dark);
            color: #fff;
        }
        footer a {
            color: #d4d4d4;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top py-2">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">
                <img src="{{ asset('final_eagri/img/agri.png') }}" alt="AgroConnect"> AgroConnect
            </a>

            <form class="d-flex mx-auto" action="{{ route('search') }}" method="get">
                <input class="form-control me-2 rounded-pill border-success" type="search" name="search"
                       placeholder="Search crops..." style="min-width: 280px;">
                <button class="btn btn-success rounded-pill px-3"><i class="fas fa-search"></i></button>
            </form>

            <div>
                @if (Session::get('c_username'))
                    <a href="{{ route('wishlist', ['c_username' => Session::get('c_username')]) }}"
                       class="btn btn-outline-success me-2"><i class="far fa-heart"></i></a>
                    <div class="dropdown d-inline">
                        <button class="btn btn-success dropdown-toggle rounded-pill" data-bs-toggle="dropdown">
                            <i class="fa fa-user"></i> {{ Session::get('c_username') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ route('cust_profile', ['c_username' => Session::get('c_username')]) }}"><i class="fa fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('cust_order_messages') }}"><i class="fas fa-box"></i> Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('c_settings') }}"><i class="fas fa-cog"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('buyer.logout') }}" method="POST">@csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-success me-2">Login</a>
                    <a href="{{ route('signup') }}" class="btn btn-success">Signup</a>
                @endif
            </div>
        </div>
    </nav>

    <!-- Secondary Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success mt-5 pt-3 shadow-sm">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav mx-auto text-uppercase fw-semibold">
                    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link px-3">Home</a></li>
                    <li class="nav-item"><a href="{{ route('about') }}" class="nav-link px-3">About</a></li>
                    <li class="nav-item"><a href="{{ route('services') }}" class="nav-link px-3">Services</a></li>
                    <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link px-3">Contact</a></li>
                    <li class="nav-item"><a href="{{ route('gallery') }}" class="nav-link px-3">Gallery</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Body -->
    <div class="container-fluid mt-5 pt-3">
        <div class="row">
            <aside class="col-lg-2 mb-4">
                <div class="card border-success shadow-sm">
                    <div class="card-header bg-success text-white fw-bold text-center">Categories</div>
                    <ul class="list-group list-group-flush">
                        @foreach (App\Models\categories_info::where('categories_status', 1)->get() as $categorie)
                            <li class="list-group-item">
                                <a href="{{ route('Categories', ['crop_type' => $categorie->id]) }}"
                                   class="text-success text-decoration-none fw-semibold">
                                   {{ $categorie->categories_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <main class="col-lg-10">
                @yield('body')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-5 mt-5">
        <div class="container text-center text-md-start">
            <div class="row g-4">
                <div class="col-md-3">
                    <h5>About AgroConnect</h5>
                    <p>Empowering sustainable agriculture through smart connections between farmers and buyers.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('news_info') }}">News</a></li>
                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <a href="#" class="me-3 text-success"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="me-3 text-danger"><i class="fab fa-youtube fa-lg"></i></a>
                    <a href="#" class="text-warning"><i class="fab fa-instagram fa-lg"></i></a>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <p>Email: agroconnect@gmail.com</p>
                    <p>Phone: +8801625738164</p>
                </div>
            </div>
            <hr>
            <p class="text-center small mb-0">&copy; {{ now()->year }} AgroConnect 🌾 All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
