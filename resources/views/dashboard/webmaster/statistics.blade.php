@extends('layouts.dashboard')

@section('sidebar')
@include('includes.dashboard.webmaster.sidebar')
@endsection

@section('title')
<h3 class="mb-0">Statistics</h3>
@endsection

@section('content')
<div class="container text-center">
    <h4 class="mb-3 text-primary">Overall:</h4>
    <div class="row align-items-center">
        <table class="table border">
            <thead>
                <tr>
                    <th scope="col">Referal code</th>
                    <th scope="col">Redirects</th>
                    <th scope="col">Award</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statistics as $statistic)
                <tr>
                    <th scope="row">{{ $statistic->id}}</th>
                    <td>{{ $statistic->title }}</td>
                    <td>{{$statistic->subscriptionsNow}}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <th scope="row">Σ {{$totalCost ?? ''}}</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="container">
    <div class="row align-items-center d-inline-flex">
        <div class="justify-content-center d-inline-flex">
            <form method="post" action="{{ url('/advertiser/statistics') }}">
                @csrf
                <input type="date" name="date" value="{{$userDate}}" class="m-4" style="transform: scale(1.3);" />
                <button type="submit" name="day" class="btn btn-outline-dark ms-1">Day</button>
                <button type="submit" name="month" class="btn btn-outline-dark ms-1">Month</button>
                <button type="submit" name="year" class="btn btn-outline-dark ms-1">Year</button>
            </form>
        </div>
    </div>
</div>
<div class="container text-center">
    <div class="row align-items-center">
        <table class="table border">
            <thead>
                <tr>
                    <th scope="col">Referal code</th>
                    <th scope="col">Redirects</th>
                    <th scope="col">Award</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dateStatistics as $dateStatistic )
                <tr>
                    <th scope="row">{{$dateStatistic->id}}</th>
                    <td>{{$dateStatistic->title}}</td>
                    <td>{{$dateStatistic->subscriptionsNow}}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <th scope="row">Σ {{$dateCost ?? ''}}</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection