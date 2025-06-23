@extends('Organization.layout')
@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header bg-warning text-dark fw-bold">
            <i class="fa-solid fa-user-shield me-2"></i>Manage Permissions for {{ $user->name }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.user.permissions.update', $user->id) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Permissions:</label>
                    <div class="row">
                        @foreach(['Create Organization', 'Update Organization', 'Delete Organization', 'Create Transaction', 'Update Transaction', 'Delete Transaction'] as $perm)
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm }}"
                                    id="perm_{{ $loop->index }}" {{ in_array($perm, $userPermissions) ? 'checked' : '' }}>
                                <label class="form-check-label" for="perm_{{ $loop->index }}">
                                    {{ $perm }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Save Permissions</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
</div>
@endsection