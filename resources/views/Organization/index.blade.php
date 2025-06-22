@extends('transactions.layout')

@section('content')
<div class="container">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <img src="{{ asset('images/logo.png') }}" class="mr-2" width="50" height="50" alt="Smart Fund"> 
            <a class="navbar-brand">Smart Fund</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/transactionDashboard') }}">Dashboard Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('transaction.index') }}">Fund Dashboard</a>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('transaction.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <button class="btn btn-link logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </button>
            </div>
        </div>
    </nav>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Transaction Dashboard</h2>
                    <h2>Hi, {{ Auth::user()->name }}</h2>
                </div>
                <div class="card-body">
                    <a href="{{ url('/transaction/create') }}" class="btn btn-success btn-create mb-3" title="Add new Transaction">Create New Fund</a>

                    @if (session('flash_message'))
                        <div class="alert alert-success">
                            {{ session('flash_message') }}
                        </div>
                    @endif

                    @if (session('update_message'))
                        <div class="alert alert-success">
                            {{ session('update_message') }}
                        </div>
                    @endif

                    @if (session('delete_message'))
                        <div class="alert alert-danger">
                            {{ session('delete_message') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->Name }}</td>
                                    <td>{{ $item->remarks }}</td>
                                    <td>
                                        <a href="{{ url('/transaction/' . $item->id) }}" title="View Details" class="btn btn-info btn-actions"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                                        <a href="{{ url('/transaction/' . $item->id . '/edit') }}" title="Edit Transaction" class="btn btn-primary btn-actions"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                                        <form method="POST" action="{{ url('/transaction' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-actions" title="Delete Transaction" onclick="return confirm('Are you sure you want to delete this transaction?')">
                                                <i class="fa fa-trash" aria-hidden="true"></i> Delete
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
    </div>
</div>
@endsection
