@extends('Organization.layout')
@section('content')

<div class="card" style="margin:20px">
    <div class="card-header">Create New Organization</div>
    <div class="card-body">
        <form action="{{ route('organizations.store') }}" method="post">
            @csrf
            <label>Name</label><br>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"><br>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            <label>Remarks</label><br>
            <input type="text" name="remarks" id="remarks" class="form-control" value="{{ old('remarks') }}"><br>
            @error('remarks')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            <input type="submit" value="Save" class="btn btn-success"><br>
        </form>
    </div>
</div>

@stop