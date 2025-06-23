<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f4f6fb;
            min-height: 100vh;
        }
        .main-navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            padding: 0.75rem 0;
        }
        .main-navbar .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            color: #0d6efd !important;
            letter-spacing: 1px;
        }
        .main-navbar .nav-link {
            color: #222 !important;
            font-weight: 500;
            margin-right: 1rem;
            border-radius: 20px;
            transition: background 0.2s, color 0.2s;
        }
        .main-navbar .nav-link.active, .main-navbar .nav-link:hover {
            background: #e3f2fd;
            color: #0d6efd !important;
        }
        .main-navbar .navbar-toggler {
            border: none;
        }
        .main-content {
            padding-top: 40px;
            padding-bottom: 40px;
        }
        .modern-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(13, 110, 253, 0.08);
            padding: 2.5rem 2rem;
            margin-bottom: 2rem;
        }
        .modern-card .card-header {
            background: none;
            color: #0d6efd;
            font-size: 1.3rem;
            font-weight: 700;
            border-bottom: 2px solid #e3f2fd;
            margin-bottom: 1.5rem;
            padding: 0;
        }
        .btn {
            border-radius: 18px;
            font-weight: 600;
            transition: background 0.2s, color 0.2s;
        }
        .btn-primary {
            background: #0d6efd;
            border: none;
        }
        .btn-primary:hover {
            background: #0b5ed7;
        }
        .btn-success {
            background: #20c997;
            border: none;
        }
        .btn-success:hover {
            background: #198754;
        }
        .btn-info {
            background: #0dcaf0;
            border: none;
            color: #fff;
        }
        .btn-info:hover {
            background: #31d2f2;
            color: #fff;
        }
        .btn-danger {
            background: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background: #bb2d3b;
        }
        .table {
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }
        .table thead {
            background: #e3f2fd;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .alert {
            border-radius: 12px;
        }
        footer {
            background: #fff;
            color: #888;
            text-align: center;
            padding: 1.5rem 0 0.5rem 0;
            border-top: 1px solid #e3f2fd;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg main-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/logo.png') }}" class="me-2" width="40" height="40" alt="Smart Fund">
            Smart Fund
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('Orgdashboard') ? 'active' : '' }}" href="{{ route('Orgdashboard') }}">
                        <i class="fa-solid fa-house me-1"></i> Dashboard Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('organizations.my') ? 'active' : '' }}" href="{{ route('organizations.my') }}">
                        <i class="fa-solid fa-building-columns me-1"></i> Fund Dashboard
                    </a>
                </li>
                <!-- User Icon and Name -->
              @auth
    <li class="nav-item dropdown ms-3">
    <a class="nav-link dropdown-toggle d-flex align-items-center text-decoration-none" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-user-circle fa-lg me-2 text-primary"></i>
        <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li>
            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="fa-solid fa-user-gear me-2"></i> Profile
            </a>
        </li>
        @php
            $role = \App\Models\UserRole::where('UserID', Auth::id())->first();
        @endphp
        @if($role && $role->RoleID == 1)
        <li>
            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge me-2"></i> Admin Dashboard
            </a>
        </li>
        @endif
        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
            </a>
        </li>
    </ul>
</li>
@endauth
                
            </ul>
        </div>
    </div>
</nav>
    <!-- Back Button just below the navbar -->
    <div class="container mt-3">
        <a href="javascript:history.back()" class="btn btn-secondary rounded-pill mb-3">
            <i class="fa-solid fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- Main Content -->
    <div class="container main-content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        &copy; {{ date('Y') }} Smart Fund. All rights reserved.
    </footer>

    <!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
</body>
</html>