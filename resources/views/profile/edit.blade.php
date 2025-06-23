@extends('Organization.layout')
@section('content')
<div class="container mt-5" style="max-width: 700px;">
    <h2 class="mb-4 fw-bold text-primary">
        <i class="fa-solid fa-user-circle me-2"></i>Profile Settings
    </h2>

    {{-- Update Profile Information --}}
    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
        <div class="mb-4">
            @livewire('profile.update-profile-information-form')
        </div>
        <hr>
    @endif

    {{-- Update Password --}}
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
        <div class="mb-4">
            @livewire('profile.update-password-form')
        </div>
        <hr>
    @endif

    {{-- Two Factor Authentication --}}
    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
        <div class="mb-4">
            @livewire('profile.two-factor-authentication-form')
        </div>
        <hr>
    @endif

   

    {{-- Account Deletion --}}
    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
        <hr>
        <div class="mb-2">
            @livewire('profile.delete-user-form')
        </div>
    @endif
</div>
@endsection