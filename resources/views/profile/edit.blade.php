@extends('layouts.layout')
@section('content')
<div class="container mt-5" style="max-width: 700px;">
    <h2 class="mb-4 fw-bold text-primary">
        <i class="fa-solid fa-user-circle me-2"></i>Profile Settings
    </h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label>New Password <small class="text-muted">(leave blank to keep current password)</small></label>
            <input type="password" name="password" class="form-control" autocomplete="new-password">
        </div>
        <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <hr class="my-4">

    <h4 class="mb-3">Two-Factor Authentication (2FA)</h4>

    @if (auth()->user()->two_factor_secret)
        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Disable 2FA</button>
        </form>
    @else
        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
            @csrf
            <button type="submit" class="btn btn-primary">Enable 2FA</button>
        </form>
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