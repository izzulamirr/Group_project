@extends('layouts.auth')

@section('content')
<div class="login-center" style="min-height:100vh;display:flex;justify-content:center;align-items:center;">
    <div class="card p-4 shadow" style="min-width:350px;max-width:400px;width:100%;">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Smart Fund" style="width:64px;height:64px;">
            <h2 class="mt-2 mb-0" style="font-weight:700;">Login</h2>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success mb-3">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Remember me</label>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                @if (Route::has('password.request'))
                    <a class="small" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
                <button type="submit" class="btn btn-primary px-4">Log in</button>
            </div>
        </form>
    </div>
</div>
@endsection