@extends('layouts.layout')


@section('content')
<div class="container">
    <h3>Edit Transaction for {{ $organization->name }}</h3>
    <form action="{{ route('organizations.transactions.update', [$organization->id, $transaction->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Donator Name</label>
            <input type="text" name="Name1" class="form-control" value="{{ $transaction->donator->Name1 ?? $transaction->donator->name }}" required>
        </div>
        <div class="mb-3">
            <label>Amount</label>
            <input type="number" name="amount" class="form-control" min="0" step="0.01" value="{{ $transaction->amount }}" required>
        </div>
        <div class="mb-3">
            <label>Remarks</label>
            <input type="text" name="remarks" class="form-control" value="{{ $transaction->remarks }}">
        </div>
        <div class="mb-3">
            <label>Receipt</label>
            <input type="file" name="receipt" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('organizations.transactions', $organization->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection