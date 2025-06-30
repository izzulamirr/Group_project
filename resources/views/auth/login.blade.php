@extends('layouts.auth')

@section('content')
<div class="login-center">
    <div class="card login-card">
        <div class="text-center mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Smart Fund" class="login-logo">
            <h2 class="login-title mt-2 mb-0">Login</h2>
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
                <button type="submit" class="btn btn-primary px-4">Log in</button>
            </div>
        </form>
    </div>
</div>
@endsection