@extends('layouts.dashboard')

@section('sidebar')
@include('includes.dashboard.administrator.sidebar')
@endsection

@section('title')
<h3 class="mb-0">Administrator</h3>
@endsection

@section('content')
<div class="container text-center">
    <h4 class="mb-3 text-primary">Overall:</h4>
    <div class="row align-items-center">
        <table class="table border">
            <thead>
                <tr>
                    <th scope="col">Generated ref_link</th>
                    <th scope="col">Generated ref_link (total)</th>
                    <th scope="col">Created offers</th>
                    <th scope="col">Publicated offers</th>
                    <th scope="col">Redirects success</th>
                    <th scope="col">Redirects fail</th>
                    <th scope="col">Income ₽</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statistics as $statistic)
                <tr>
                    <td>{{$statistic['refLinkCount']}}</td>
                    <td>{{ $statistic['refLinkTotal']}}</td>
                    <td>{{ $statistic['offersCreated'] }}</td>
                    <td>{{ $statistic['offersPublicated'] }}</td>
                    <td>{{ $statistic['redirectsSuccess'] }}</td>
                    <td>{{ $statistic['redirectsFail'] }}</td>
                    <td>{{ $statistic['totalIncome'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="container">
    <div class="row align-items-center d-inline-flex">
        <div class="justify-content-center d-inline-flex">
            <form method="post" action="{{ url('/administrator/statistics') }}">
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
                    <th scope="col">Generated ref_link</th>
                    <th scope="col">Generated ref_link (total)</th>
                    <th scope="col">Created offers</th>
                    <th scope="col">Publicated offers</th>
                    <th scope="col">Redirects success</th>
                    <th scope="col">Redirects fail</th>
                    <th scope="col">Income ₽</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dateStatistics as $dateStatistic)
                <tr>
                    <td>{{$dateStatistic['refLinkCount']}}</td>
                    <td>{{ $dateStatistic['refLinkTotal']}}</td>
                    <td>{{ $dateStatistic['offersCreated'] }}</td>
                    <td>{{ $dateStatistic['offersPublicated'] }}</td>
                    <td>{{ $dateStatistic['redirectsSuccess'] }}</td>
                    <td>{{ $dateStatistic['redirectsFail'] }}</td>
                    <td>{{ $dateStatistic['dateIncome'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection