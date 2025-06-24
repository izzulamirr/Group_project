@extends('layouts.homepage')

@section('content')
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
@endsection