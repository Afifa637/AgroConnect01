<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Farmer Dashboard - AgroConnect')</title>

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
            width: 250px;
            position: fixed;
            background: #fff;
            border-right: 2px solid #e0ebe3;
            top: 56px;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: background 0.2s;
            font-weight: 500;
        }

        .sidebar a.active,
        .sidebar a:hover {
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
    <!-- 🧭 Top Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold text-success" href="{{ route('home') }}">
                <img src="{{ asset('final_eagri/img/logo.png') }}" alt="AgroConnect"
                    style="height:35px; width:auto; transform:scale(3); transform-origin:left;">
            </a>

            <form class="d-flex ms-auto me-3" action="{{ route('farmer.search') }}" method="GET">
                <input class="form-control form-control-sm me-2" type="search" name="query"
                    placeholder="Search crops or buyers...">
                <button class="btn btn-light btn-sm"><i class="fa fa-search"></i></button>
            </form>

            <ul class="navbar-nav align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link text-white position-relative" href="{{ route('farmer_orders') }}">
                        <i class="fa fa-bell"></i>

                        @if (!empty($orderCount) && $orderCount > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $orderCount }}
                            </span>
                        @endif
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                        <i class="fa fa-user-circle me-1"></i>{{ Session::get('f_username') }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item"
                                href="{{ route('fa_profile', ['f_username' => Session::get('f_username')]) }}">Profile</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('crop_manage') }}">Manage Crops</a></li>
                        <li><a class="dropdown-item" href="{{ route('farmer_orders') }}">Orders</a></li>
                        <li><a class="dropdown-item" href="{{ route('farm_bid_messages') }}">Bids & Messages</a></li>
                        <li><a class="dropdown-item" href="{{ route('f_settings') }}">Settings</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('farmer.logout') }}" method="POST">@csrf
                                <button class="dropdown-item text-danger"><i
                                        class="fas fa-sign-out-alt me-1"></i>Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- 🌿 Sidebar -->
    <div class="sidebar">
        <div class="text-center mb-4">
            <img src="{{ asset($user->profile_pic ?? 'default.png') }}" class="img-thumbnail rounded-circle"
                width="150">
            <h6>{{ Session::get('f_username') }}</h6>
            <p class="small text-muted">Farmer</p>
        </div>

        <a href="{{ route('f_home') }}" class="{{ request()->routeIs('f_home') ? 'active' : '' }}">
            <i class="fa fa-home me-2"></i> Dashboard
        </a>

        <a href="{{ route('crop_manage') }}" class="{{ request()->routeIs('crop_manage') ? 'active' : '' }}">
            <i class="fa fa-seedling me-2"></i> Manage Crops
        </a>

        <a href="{{ route('crop_import') }}" class="{{ request()->routeIs('crop_import') ? 'active' : '' }}">
            <i class="fa fa-upload me-2"></i> Add / Import Crops
        </a>

        <a href="{{ route('farm_bid_messages') }}"
            class="{{ request()->routeIs('farm_bid_messages') ? 'active' : '' }}">
            <i class="fa fa-comments me-2"></i> Bid Messages
        </a>

        <a href="{{ route('farmer_orders') }}" class="{{ request()->routeIs('farmer_orders') ? 'active' : '' }}">
            <i class="fa fa-box me-2"></i> Orders
        </a>

        <a href="{{ route('fa_profile', ['f_username' => Session::get('f_username')]) }}"
            class="{{ request()->routeIs('fa_profile') ? 'active' : '' }}">
            <i class="fa fa-user me-2"></i> Profile
        </a>

        <a href="{{ route('f_settings') }}" class="{{ request()->routeIs('f_settings') ? 'active' : '' }}">
            <i class="fa fa-cog me-2"></i> Settings
        </a>

        <hr>

        <h6 class="text-success">Analytics</h6>
        <a href="#"><i class="fa fa-chart-line me-2"></i> Sales Stats</a>
        <a href="#"><i class="fa fa-wallet me-2"></i> Earnings</a>
        <a href="#"><i class="fa fa-user-friends me-2"></i> Customer Insights</a>
    </div>

    <!-- 🌾 Main Content -->
    <div class="content">
        @yield('body')
    </div>

    <!-- 🌱 Footer -->
    <footer>
        <p class="mb-1">&copy; {{ now()->year }} AgroConnect — Farmer Portal</p>
        <p class="small"><a href="{{ route('contact') }}">Contact Support</a></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
