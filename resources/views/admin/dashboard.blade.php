@extends('layouts.layout')
@section('content')
<div class="container py-4">

    @if(session('flash_message'))
        <div class="alert alert-success">
            {{ session('flash_message') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.user.create') }}" class="btn btn-success">
            <i class="fa fa-user-plus me-1"></i> Add User
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-dark text-white rounded-top-4 fs-5 fw-bold">
            <i class="fa-solid fa-gauge me-2"></i>Admin Dashboard
        </div>
        <div class="card-body">
            <h5 class="mb-4">All Users, Organizations & Transactions</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Organizations<br><span class="fw-normal">(Count)</span></th>
                            <th>Transactions<br><span class="fw-normal">(Count &amp; Total Donations)</span></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        @php
                            $orgCount = $user->organizations->count();
                            $transactions = $user->organizations->pluck('transactions')->flatten();
                            $txnCount = $transactions->count();
                            $totalDonations = $transactions->sum('amount');
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-primary mb-2">{{ $orgCount }}</span>
                                @if($orgCount > 0)
                                    <a href="{{ route('admin.user.organizations', $user->id) }}" class="btn btn-outline-primary btn-sm ms-2">
                                        Show All Organizations
                                    </a>
                                @else
                                    <span class="text-muted">No organizations</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info mb-2">{{ $txnCount }} transactions</span>
                                <span class="badge bg-success mb-2">RM {{ number_format($totalDonations, 2) }}</span>
                                <br>
                                @if($txnCount == 0)
                                    <span class="text-muted">No transactions</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.user.permissions', $user->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-user-shield me-1"></i> Manage Permissions
                                </a>
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection