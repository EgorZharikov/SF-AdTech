@extends('layouts.dashboard')

@section('sidebar')
@include('includes.dashboard.advertiser.sidebar')
@endsection

@section('title')
<h3 class="mb-0">Statistics</h3>
@endsection
@section('content')

<div class="container text-center">
    <div class="row align-items-center">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Offer title</th>
                    <th scope="col">Subscriptions now</th>
                    <th scope="col">Subscriptions total</th>
                    <th scope="col">Redirects</th>
                    <th scope="col">Redirect award</th>
                    <th scope="col">Costs ₽</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statistics as $statistic)
                <tr>
                    <th scope="row">{{ $statistic['id']}}</th>
                    <td>{{ $statistic['title'] }}</td>
                    <td>{{ $statistic['sub_now'] }}</td>
                    <td>{{ $statistic['sub_total']}}</td>
                    <td>{{ $statistic['redirects'] }}</td>
                    <td>{{ $statistic['redirect_award'] }}</td>
                    <td>{{ $statistic['costs'] }}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th scope="row">Σ {{$total}}</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="container">
    <div class="row align-items-center d-inline-flex">
        <div class="justify-content-center d-inline-flexs">
            <form method="post" action="{{ url('/advertiser/statistics') }}">
                @csrf
                <input type="date" name="date" value="{{date('Y-m-d')}}" class="m-4" style="transform: scale(1.3);" />
                <button type="submit" name="day" class="btn btn-outline-dark ms-1">Day</button>
                <button type="submit" name="month" class="btn btn-outline-dark ms-1">Month</button>
                <button type="submit" name="year" class="btn btn-outline-dark ms-1">Year</button>
            </form>
        </div>
    </div>
</div>
<div class="container">
    <div class="row align-items-center">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Offer title</th>
                    <th scope="col">Subscriptions now</th>
                    <th scope="col">Subscriptions total</th>
                    <th scope="col">Redirects</th>
                    <th scope="col">Redirect award</th>
                    <th scope="col">Costs ₽</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th scope="row">Σ</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection