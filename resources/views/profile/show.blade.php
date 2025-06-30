@extends('layouts.layout')
@section('content')
<div class="container mt-5" style="max-width: 700px;">
    <h2 class="mb-4 fw-bold text-primary">
        <i class=""></i>Profile Settings
    </h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <label class="form-label fw-bold">Name</label>
        <div class="form-control-plaintext">{{ $user->name }}</div>
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Email</label>
        <div class="form-control-plaintext">{{ $user->email }}</div>
    </div>
    <div class="mb-3">
        <label class="form-label fw-bold">Password</label>
        <div class="form-control-plaintext">********</div>
    </div>
    <a href="{{ route('profile.edit') }}" class="btn btn-primary mb-4">
        <i class="fa-solid fa-user-pen me-2"></i> Edit Profile
    </a>

    <hr class="my-4">

    <h4 class="mb-3">Two-Factor Authentication (2FA)</h4>

   @if (auth()->user()->two_factor_secret)
    <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Disable 2FA</button>
    </form>
   <button class="btn btn-secondary mt-3" type="button" id="show2faBtn">
    Show 2FA QR & Recovery Codes
    </button>
    <div id="twofa-details" class="mt-3 d-none">
        <p>Scan this QR code with your authenticator app:</p>
        {!! auth()->user()->twoFactorQrCodeSvg() !!}
        <p class="mt-2">Recovery Codes:</p>
        <ul>
            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                <li>{{ $code }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('status') == 'two-factor-authentication-enabled')
    <div class="mt-3">
        <p>Scan this QR code with your authenticator app:</p>
        {!! auth()->user()->twoFactorQrCodeSvg() !!}
        <p class="mt-2">Recovery Codes:</p>
        <ul>
            @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                <li>{{ $code }}</li>
            @endforeach
        </ul>
    </div>
@endif
</div>
@endsection