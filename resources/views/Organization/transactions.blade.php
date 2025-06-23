@extends('Organization.layout')
@section('content')
<div class="container mt-4">
    <h3>Transactions for {{ $organization->name }}</h3>
    @if(session('flash_message'))
        <div class="alert alert-success">{{ session('flash_message') }}</div>
    @endif

    @php
        $role = \App\Models\UserRole::where('UserID', Auth::id())->first();
        $canCreate = $role ? \App\Models\RolePermission::where('RoleID', $role->RoleID)->where('Description', 'Create Transaction')->exists() : false;
        $canEdit = $role ? \App\Models\RolePermission::where('RoleID', $role->RoleID)->where('Description', 'Update Transaction')->exists() : false;
        $canDelete = $role ? \App\Models\RolePermission::where('RoleID', $role->RoleID)->where('Description', 'Delete Transaction')->exists() : false;
    @endphp

    @if($canCreate)
    <a href="{{ route('organizations.transactions.create', $organization->id) }}" class="btn btn-success mb-3">
        <i class="fa fa-plus"></i> Add Transaction
    </a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Donator</th>
                <th>Amount</th>
                <th>Remarks</th>
                <th>Donation Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
           @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->donator->Name1 ?? '-' }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->remarks }}</td>
                <td>{{ $transaction->created_at }}</td>
                <td>
                    @if($canEdit)
                    <a href="{{ route('organizations.transactions.edit', [$organization->id, $transaction->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                    @endif
                    @if($canDelete)
                    <form action="{{ route('organizations.transactions.destroy', [$organization->id, $transaction->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this transaction?')">Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
           @endforeach
        </tbody>
    </table>
    <h5>Total Donations: RM {{ $total }}</h5>
</div>
@endsection