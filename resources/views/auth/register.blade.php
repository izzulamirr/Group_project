@extends('layouts.auth')

@section('content')
<div class="login-center" style="min-height:100vh;display:flex;justify-content:center;align-items:center;">
    <div class="card p-4 shadow" style="min-width:350px;max-width:400px;width:100%;">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Smart Fund" style="width:64px;height:64px;">
            <h2 class="mt-2 mb-0" style="font-weight:700;">Register</h2>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <div class="mt-3 text-center">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}">Login</a>
        </div>
    </div>
@endsection