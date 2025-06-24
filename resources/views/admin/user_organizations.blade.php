@extends('layouts.layout')
@section('content')
<div class="container py-4">
    <h3>Organizations for {{ $user->name }}</h3>
    <div class="card mt-3">
        <div class="card-body">
            @if($user->organizations->isEmpty())
                <p class="text-muted">No organizations found.</p>
            @else
                <ul class="list-group">
                    @foreach($user->organizations as $org)
                        <li class="list-group-item">
                            <strong>{{ $org->name }}</strong>
                            <span class="text-muted">({{ $org->remarks }})</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection