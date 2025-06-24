@extends('layouts.layout')
@section('content')

@php
use App\Models\Organization;
$organizationCount = Organization::where('user_id', auth()->id())->count();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Smart Fund</title>
    <link href="{{ asset('css/dash.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Montserrat', Arial, sans-serif;
            background: #f8fafc;
        }
       
        .logout-button {
            color: #fff;
            font-weight: 500;
            text-decoration: underline;
            background: none;
            border: none;
            margin-left: 1rem;
        }
        .dashboard-box {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(13, 202, 240, 0.08);
            padding: 2rem 2.5rem;
            margin: 2rem auto 2rem auto;
            max-width: 400px;
            text-align: center;
        }
        .dashboard-box .count {
            font-size: 3rem;
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 0.5rem;
        }
        .dashboard-box .label {
            font-size: 1.2rem;
            color: #333;
            font-weight: 500;
        }
        #transactionChart {
            max-width: 700px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(13, 202, 240, 0.08);
            padding: 2rem;
        }
    </style>
</head>
<body>
    

    <div class="dashboard-box">
        <p class="count">{{ $organizationCount }}</p>
        <p class="label">Organization(s) Created</p>
    </div>


   </body>
</html>
@endsection