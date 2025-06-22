@extends('transactions.layout')
@section('content')

<div class="card" style="margin:20px">
    <div class="card-header">View Transaction</div>
    <div class="card-body">
        @if ($transaction)
            <h5 class="card-title">Name: {{ $transaction->Name }}</h5>
            <p class="card-text">Remarks: {{ $transaction->remarks }}</p>
        @else
            <p>No transaction found.</p>
        @endif
    </div>
    <div class="card-body">
        <a href="{{ route('transaction.Newstat') }}" class="btn btn-success btn-create mb-3" title="Add new Profile">Add Items</a>
        <a href="{{ route('Profile.view') }}" class="btn btn-success btn-create mb-3" title="See Items">See Items</a>
    </div>
</div>

@endsection
