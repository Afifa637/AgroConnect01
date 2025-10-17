<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Buyer Dashboard - AgroConnect')</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --agro-green: #198754;
            --agro-bg: #f7faf9;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--agro-bg);
        }

        .navbar {
            background-color: var(--agro-green);
            color: white;
        }

        .sidebar {
            height: 100vh;
            background-color: #fff;
            border-right: 2px solid #e0ebe3;
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            overflow-y: auto;
            padding: 20px;
        }

        .sidebar h6 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--agro-green);
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: background 0.2s;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: var(--agro-green);
            color: #fff;
        }

        .content {
            margin-left: 250px;
            padding: 30px;
        }

        footer {
            background: #1b1f1a;
            color: #ddd;
            padding: 20px 0;
            text-align: center;
        }

        footer a {
            color: #a5cba1;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- 🟢 Top Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold text-white" href="{{ route('home') }}">
                <i class="fa-solid fa-leaf me-2"></i>AgroConnect
            </a>

            <form class="d-flex ms-auto me-3" action="{{ route('search') }}" method="GET">
                <input class="form-control form-control-sm me-2" type="search" name="query" placeholder="Search crops...">
                <button class="btn btn-light btn-sm"><i class="fa fa-search"></i></button>
            </form>

            <ul class="navbar-nav align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link text-white position-relative" href="#">
                        <i class="fa fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                    </a>
                </li>
                @if(Session::has('c_username'))
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                        <i class="fa fa-user-circle me-1"></i>{{ Session::get('c_username') }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('cust_profile', ['c_username' => Session::get('c_username')]) }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('wishlist', ['c_username' => Session::get('c_username')]) }}">Wishlist</a></li>
                        <li><a class="dropdown-item" href="{{ route('cust_order_messages') }}">Orders</a></li>
                        <li><a class="dropdown-item" href="{{ route('c_settings') }}">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('buyer.logout') }}" method="POST" class="d-inline">@csrf
                                <button class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-1"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
    </nav>

    <!-- 🟢 Sidebar -->
    <div class="sidebar">
        <h6>Categories</h6>
        @if(!empty($categories))
            @foreach($categories as $category)
                @if(!empty($category->crop_type))
                <a href="{{ route('categories', ['crop_type' => $category->crop_type]) }}" 
                   class="{{ request()->is('categories/'.$category->crop_type) ? 'active' : '' }}">
                   <i class="fa fa-seedling me-2"></i> {{ ucfirst($category->crop_type) }}
                </a>
                @endif
            @endforeach
        @endif

        <hr>

        @if(Session::has('c_username'))
        <a href="{{ route('wishlist', ['c_username' => Session::get('c_username')]) }}" 
           class="{{ request()->routeIs('wishlist') ? 'active' : '' }}">
           <i class="fa fa-heart me-2"></i> Wishlist
        </a>
        @endif

        <a href="{{ route('cust_order_messages') }}" 
           class="{{ request()->routeIs('cust_order_messages') ? 'active' : '' }}">
           <i class="fa fa-box me-2"></i> Orders
        </a>
        <a href="{{ route('c_message') }}" 
           class="{{ request()->routeIs('c_message') ? 'active' : '' }}">
           <i class="fa fa-envelope me-2"></i> Messages
        </a>
    </div>

    <!-- 🟢 Main Page Content -->
    <div class="content">
        @yield('body')
    </div>

    <!-- 🟢 Footer -->
    <footer>
        <p class="mb-1">&copy; {{ now()->year }} AgroConnect — Buyer Portal</p>
        <p class="small"><a href="{{ route('contact') }}">Contact Support</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
