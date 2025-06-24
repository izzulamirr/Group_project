@extends('layouts.layout')
@section('content')
<div class="container py-4">

    <!-- Card for Organization List -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 fs-5 fw-bold">
            <i class="fa-solid fa-list me-2"></i>List of Organizations
        </div>
        <div class="card-body">
            @if (session('flash_message'))
                <div class="alert alert-success">
                    {{ session('flash_message') }}
                </div>
            @endif
            @if (session('delete_message'))
                <div class="alert alert-danger">
                    {{ session('delete_message') }}
                </div>
            @endif

            @php
                $role = \App\Models\UserRole::where('UserID', Auth::id())->first();
                $canCreate = $role ? \App\Models\RolePermission::where('RoleID', $role->RoleID)->where('Description', 'Create Organization')->exists() : false;
                $canEdit = $role ? \App\Models\RolePermission::where('RoleID', $role->RoleID)->where('Description', 'Update Organization')->exists() : false;
                $canDelete = $role ? \App\Models\RolePermission::where('RoleID', $role->RoleID)->where('Description', 'Delete Organization')->exists() : false;
            @endphp

            @if($canCreate)
            <a href="{{ route('organizations.create') }}" class="btn btn-success mb-3 rounded-pill px-4 py-2" title="Add new Organization">
                <i class="fa-solid fa-plus me-1"></i> Add Organization
            </a>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Organization Name</th>
                            <th scope="col">Remarks</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($organizations as $organization)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-semibold">{{ $organization->name }}</td>
                            <td>{{ $organization->remarks ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('organizations.transactions', $organization->id) }}" class="btn btn-info btn-sm rounded-pill mb-1">
                                    <i class="fa-solid fa-eye me-1"></i> View Transactions
                                </a>
                                @if($canEdit)
                                <a href="{{ route('organizations.edit', $organization->id) }}" class="btn btn-primary btn-sm rounded-pill mb-1">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </a>
                                @endif
                                @if($canDelete)
                                <form method="POST" action="{{ route('organizations.destroy', $organization->id) }}" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill mb-1"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fa-solid fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @if($organizations->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted">No organizations found.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection