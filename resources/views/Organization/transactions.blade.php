@extends('Organization.layout')
@section('content')
<div class="container mt-4">
    <h3>Transactions for {{ $organization->name }}</h3>
    @if(session('flash_message'))
        <div class="alert alert-success">{{ session('flash_message') }}</div>
    @endif
    <a href="{{ route('organizations.transactions.create', $organization->id) }}" class="btn btn-success mb-3">
        <i class="fa fa-plus"></i> Add Transaction
    </a>
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
                    <a href="{{ route('organizations.transactions.edit', [$organization->id, $transaction->id]) }}" class="btn btn-primary btn-sm">Edit</a>
                    <form action="{{ route('organizations.transactions.destroy', [$organization->id, $transaction->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Delete this transaction?')">Delete</button>
                    </form>
                </td>
            </tr>
           @endforeach
        </tbody>
    </table>
    <h5>Total Donations: RM {{ $total }}</h5>
</div>
@endsection