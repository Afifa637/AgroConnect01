<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Buyer Dashboard - AgroConnect')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --agro-green: #198754;
            --agro-bg: #f7faf9;
        }
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: 'Poppins', sans-serif;
            background: var(--agro-bg);
        }
        body {
            flex: 1 0 auto;
        }
        .navbar {
            background-color: var(--agro-green);
            color: white;
        }
        .sidebar {
            height: calc(100vh - 56px);
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
        .sidebar a:hover,
        .sidebar a.active {
            background-color: var(--agro-green);
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 30px;
            flex: 1 0 auto;
        }
        footer {
            background: #494a49;
            color: #ddd;
            padding: 20px 0;
            text-align: center;
            flex-shrink: 0;
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
                <img src="{{ asset('final_eagri/img/logo.png') }}" alt="AgroConnect"
                    style="height:35px; width:auto; transform:scale(3); transform-origin:left;">
            </a>

            <form class="d-flex ms-auto me-3" action="{{ route('search') }}" method="GET">
                <input class="form-control form-control-sm me-2" type="search" name="query"
                    placeholder="Search crops...">
                <button class="btn btn-light btn-sm"><i class="fa fa-search"></i></button>
            </form>

            <ul class="navbar-nav align-items-center">
                <li class="nav-item me-3">
                    <a class="nav-link text-white position-relative" href="{{ route('cust_order_messages') }}">
                        <i class="fa fa-bell"></i>
                        @if (!empty($orderCount) && $orderCount > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $orderCount }}
                            </span>
                        @endif
                    </a>
                </li>
                @if (Session::has('c_username'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fa fa-user-circle me-1"></i>{{ Session::get('c_username') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item"
                                    href="{{ route('cust_profile', ['c_username' => Session::get('c_username')]) }}">Profile</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('wishlist', ['c_username' => Session::get('c_username')]) }}">Wishlist</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('cust_order_messages') }}">Orders</a></li>
                            <li><a class="dropdown-item" href="{{ route('c_settings') }}">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('buyer.logout') }}" method="POST" class="d-inline">@csrf
                                    <button class="dropdown-item text-danger"><i
                                            class="fas fa-sign-out-alt me-1"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>

    <!-- 🟢 Sidebar -->
    <div class="sidebar text-center">
        @if (Session::has('c_username'))
            <div class="mb-4">
                <img src="{{ asset('storage/'.$user->profile_pic ?? 'default.png') }}" class="rounded-circle border-2"
                    width="100" height="100" alt="Profile">
                <h6 class="mt-2 fw-bold text-success">{{ Session::get('c_username') }}</h6>
            </div>
        @endif

        <a href="{{ route('home') }}" class="mb-2 d-block btn btn-sm btn-success text-white">
            <i class="fa fa-home me-2"></i> Browse Crops
        </a>
        <hr>
        @if (Session::has('c_username'))
            <a href="{{ route('wishlist', ['c_username' => Session::get('c_username')]) }}"
                class="{{ request()->routeIs('wishlist') ? 'active' : '' }}">
                <i class="fa fa-heart me-2"></i> Wishlist
            </a>
            <a href="{{ route('cust_order_messages') }}"
                class="{{ request()->routeIs('cust_order_messages') ? 'active' : '' }}">
                <i class="fa fa-box me-2"></i> Orders
            </a>
            <a href="{{ route('c_message') }}" class="{{ request()->routeIs('c_message') ? 'active' : '' }}">
                <i class="fa fa-envelope me-2"></i> Messages
            </a>
            <a href="{{ route('c_settings') }}" class="{{ request()->routeIs('c_settings') ? 'active' : '' }}">
                <i class="fa fa-cog me-2"></i> Settings
            </a>
        @endif
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show preview for any input type="file"
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            let imgPreview = input.closest('.mb-3, .col-md-12')?.querySelector(
                                'img.img-thumbnail');
                            if (!imgPreview) {
                                imgPreview = document.createElement('img');
                                imgPreview.classList.add('img-thumbnail', 'mt-2');
                                imgPreview.width = 120;
                                input.closest('.mb-3, .col-md-12').appendChild(imgPreview);
                            }
                            imgPreview.src = ev.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });
        });
    </script>
</body>

</html>

</body>

</html>
