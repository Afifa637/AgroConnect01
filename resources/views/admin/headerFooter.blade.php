<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'AgroConnect - Admin')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom Theme -->
    <link href="{{ asset('css/agro-theme.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #f9fafb;
        }
        .sidebar {
            height: 100vh;
            background: #198754;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            overflow-y: auto;
            padding-top: 70px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 500;
        }
        .sidebar a:hover, .sidebar .active {
            background: #157347;
            color: #fff;
        }
        .content {
            margin-left: 240px;
            padding: 30px;
        }
        footer {
            margin-left: 240px;
            background: #198754;
            color: white;
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .chart-container {
            position: relative;
            height: 350px;
            width: 100%;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- 🌿 Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand ms-3 fw-bold" href="{{ route('a_home') }}">
                <i class="bi bi-speedometer2"></i> AgroConnect Admin
            </a>

            <div class="d-flex align-items-center me-3">
                <form class="d-flex me-3" action="{{ route('admin_search') }}" method="get">
                    @csrf
                    <input class="form-control form-control-sm me-2" type="search" name="search" placeholder="Search crops, news, etc.">
                    <button class="btn btn-light btn-sm" type="submit"><i class="bi bi-search"></i></button>
                </form>

                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> {{ Session::get('a_username') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('a_profile') }}"><i class="bi bi-person"></i> Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('a_settings') }}"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"
                                    onclick="return confirm('Are you sure you want to logout?');">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- 🌱 Sidebar -->
    <div class="sidebar">
        <h5 class="text-center mb-3"><i class="bi bi-grid-fill"></i> Dashboard</h5>
        <hr class="border-light mx-3">

        <a href="{{ route('a_home') }}" class="{{ request()->routeIs('a_home') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Home
        </a>

        <a href="{{ route('manage_categories') }}" class="{{ request()->routeIs('manage_categories') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Manage Categories
        </a>

        <a href="{{ route('add_categories') }}" class="{{ request()->routeIs('add_categories') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> Add Category
        </a>

        <a href="{{ route('manage_news') }}" class="{{ request()->routeIs('manage_news') ? 'active' : '' }}">
            <i class="bi bi-newspaper"></i> Manage News
        </a>

        <a href="{{ route('add_news') }}" class="{{ request()->routeIs('add_news') ? 'active' : '' }}">
            <i class="bi bi-pencil-square"></i> Add News
        </a>

        <a href="{{ route('published_crops') }}" class="{{ request()->routeIs('published_crops') ? 'active' : '' }}">
            <i class="bi bi-check-circle"></i> Published Crops
        </a>

        <a href="{{ route('unpublished_crops') }}" class="{{ request()->routeIs('unpublished_crops') ? 'active' : '' }}">
            <i class="bi bi-x-circle"></i> Unpublished Crops
        </a>

        <a href="{{ route('deleted_crops') }}" class="{{ request()->routeIs('deleted_crops') ? 'active' : '' }}">
            <i class="bi bi-trash"></i> Deleted Crops
        </a>

        <a href="{{ route('all_farmer') }}" class="{{ request()->routeIs('all_farmer') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i> All Farmers
        </a>

        <a href="{{ route('all_customer') }}" class="{{ request()->routeIs('all_customer') ? 'active' : '' }}">
            <i class="bi bi-people"></i> All Buyers
        </a>
        <a href="{{ route('admin.contact_messages') }}" class="{{ request()->routeIs('admin.contact_messages') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> Contact Messages
        </a>        
    </div>

    <!-- 🌾 Main Content -->
    <div class="content">
        @yield('body')
    </div>

    <!-- 🌿 Footer -->
    <footer class="text-center py-3 mt-5 shadow">
        © {{ date('Y') }} AgroConnect Admin Panel — All rights reserved.
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
