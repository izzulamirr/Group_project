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
  
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Script -->
    <script src="{{ asset('js/script.js') }}"></script>
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
                    <a class="nav-link nav-big-btn {{ request()->routeIs('Orgdashboard') ? 'active' : '' }}" href="{{ route('Orgdashboard') }}">
                        Dashboard Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-big-btn {{ request()->routeIs('organizations.my') ? 'active' : '' }}" href="{{ route('organizations.my') }}">
                        Fund Dashboard
                    </a>
                </li>
                <!-- User Icon and Name -->
                @auth
                <li class="nav-item dropdown ms-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-decoration-none" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fw-semibold text-dark">{{ Auth::user()->name }}</span>
                    </a>
                   <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            Profile
                        </a>
                    </li>
                    
                        @php
                            $role = \App\Models\UserRole::where('UserID', Auth::id())->first();
                        @endphp
                        @if($role && $role->RoleID == 1)
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                Admin Dashboard
                            </a>
                        </li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                           <a class="dropdown-item text-danger" href="#" id="logout-link">
                            Logout
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
    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg">
        Back
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

   <!-- Hidden logout form (only one per page) -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@yield('scripts')

</body>
</html>



