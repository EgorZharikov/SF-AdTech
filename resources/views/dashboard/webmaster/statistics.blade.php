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
                        <th scope="col">Award for redirect</th>
                        <th scope="col">Service fee</th>
                        <th scope="col">Award</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statistics as $statistic)
                        <tr>
                            <th scope="row">{{ $statistic->referal_link }}</th>
                            <td>{{ $statistic->redirects_count }}</td>
                            <td>{{ $statistic->award }}</td>
                            <td>{{ $statistic->fee }}</td>
                            <th scope="row"> {{ $statistic->redirects_count * ($statistic->award - $statistic->fee) }}
                            </th>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th scope="row">Σ {{ $totalAward ?? '' }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center d-inline-flex">
            <div class="justify-content-center d-inline-flex">
                <form method="post" action="{{ url('/webmaster/statistics') }}">
                    @csrf
                    <input type="date" name="date" value="{{ $userDate }}" class="m-4"
                        style="transform: scale(1.3);" />
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
                        <th scope="col">Award for redirect</th>
                        <th scope="col">Service fee</th>
                        <th scope="col">Award</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dateStatistics as $dateStatistic)
                        <tr>
                            <th scope="row">{{ $dateStatistic->referal_link }}</th>
                            <td>{{ $dateStatistic->redirects_count }}</td>
                            <td>{{ $dateStatistic->award }}</td>
                            <td>{{ $dateStatistic->fee }}</td>
                            <th scope="row"> {{ $dateStatistic->redirects_count * ($dateStatistic->award - $dateStatistic->fee) }}
                            </th>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <th scope="row">Σ {{ $dateAward ?? '' }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
