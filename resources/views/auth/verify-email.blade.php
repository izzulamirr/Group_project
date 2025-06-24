@extends('layouts.layout')

@section('content')
<div class="container mt-5" style="max-width: 400px;">
    <h4 class="mb-3">Email Verification Required</h4>
    <div class="mb-4 text-muted">
        Before continuing, please enter the verification code sent to your email address.
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success mt-2">
                A new verification code has been sent to your email address.
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('verification.verify') }}">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Verification Code</label>
            <input type="text" name="code" id="code" class="form-control" required>
            @error('code')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100">Verify</button>
    </form>

    <form method="POST" action="{{ route('verification.resend') }}" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-link">Resend Verification Code</button>
    </form>

    <div class="mt-3 d-flex justify-content-between">
        <a href="{{ route('profile.edit') }}" class="text-decoration-underline">Edit Profile</a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-link text-danger p-0">Log Out</button>
        </form>
    </div>
</div>
@endsection