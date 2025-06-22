@extends('Organization.layout')
@section('content')

<div class="card" style="margin:20px">
    <div class="card-header">Edit Organization</div>
    <div class="card-body">
        <form action="{{ route('organizations.update', $organization->id) }}" method="post">
            @csrf
            @method('PUT') 
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" value="{{ $organization->name }}">
            </div>

            <div class="form-group">
                <label for="remarks">Remarks:</label>
                <textarea name="remarks" class="form-control">{{ $organization->remarks }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection