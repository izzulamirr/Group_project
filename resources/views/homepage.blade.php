<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Fund</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Script -->
    <script src="{{ asset('js/script.js') }}"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo.png') }}" class="me-2" width="48" height="48" alt="Smart Fund">
                <span class="fw-bold fs-4">Smart Fund</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link btn btn-warning px-4 py-2" href="{{ route('transaction.donate') }}">
                                <i class="fa-solid fa-hand-holding-heart me-1"></i> Donate
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn text-white px-4 py-2" href="{{ route('login') }}">
                                <i class="fa-solid fa-user me-1"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn text-white px-4 py-2" href="{{ route('register') }}">
                                <i class="fa-solid fa-user-plus me-1"></i> Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link btn text-white px-4 py-2" href="{{ route('Orgdashboard') }}">
                                <i class="fa-solid fa-gauge me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="nav-link btn btn-danger text-white px-4 py-2" style="border:none; background:none;">
                                    <i class="fa-solid fa-sign-out-alt me-1"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Features Section -->
    <section class="features container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 feature-item text-center mx-2">
                <i class="fas fa-chart-line fa-3x mb-3"></i>
                <h3 class="fw-bold">User Friendly</h3>
                <p>Easy to operate, simple and customizable for everyone.</p>
            </div>
            <div class="col-md-4 feature-item text-center mx-2">
                <i class="fas fa-laptop-code fa-3x mb-3"></i>
                <h3 class="fw-bold">Efficient</h3>
                <p>Quick, reliable, and optimized for performance.</p>
            </div>
            <div class="col-md-4 feature-item text-center mx-2">
                <i class="fas fa-lock fa-3x mb-3"></i>
                <h3 class="fw-bold">Integrity</h3>
                <p>Great security and hard to bypass, keeping your data safe.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; 2023 Smart Fund. All rights reserved. <a href="/privacy">Privacy Policy</a></p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>