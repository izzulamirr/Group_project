@extends('Organization.layout')
@section('content')
<div class="container mt-4">
    <h3>Add Transaction for {{ $organization->name }}</h3>
    <form action="{{ route('organizations.transactions.store', $organization->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Donator Name</label>
            <input type="text" name="donator_name" class="form-control" placeholder="Enter donator name" required>
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" min="0" step="0.01" required>
        </div>
        <div class="mb-3">
            <label>Remarks</label>
            <input type="text" name="remarks" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="{{ route('organizations.transactions', $organization->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection