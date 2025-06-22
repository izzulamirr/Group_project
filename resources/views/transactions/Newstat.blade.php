@extends('transactions.layout') <!-- Extends the layout -->
@section('content') <!-- Start of content section -->

<div class="card" style="margin:20px">
    <div class="card-header"> Create New Profile</div>
    <div class="card-body">
   <!-- transactions.Newstat.blade.php -->
<form action="{{ route('transaction.store') }}" method="post">
    @csrf <!-- CSRF token -->
    <label> Name</label><br>
    <input type="text" name="Name1" id="Name1" class="form-control"><br>
    <label> Amount</label><br>
    <input type="text" name="amount" id="amount" class="form-control"><br>
    <input type="submit" name="Save" class="btn btn-success"><br>
</form>

    </div>
</div>

@endsection <!-- End of content section -->
