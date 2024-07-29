@extends('layouts.dashboard')

@section('sidebar')
@include('includes.dashboard.webmaster.sidebar')
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
                    <th scope="col">Referal code</th>
                    <th scope="col">Redirects</th>
                    <th scope="col">Award ₽</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statistics as $statistic )
                <tr>
                    <td>{{ $statistic['subscription'] }}</td>
                    <td>{{$statistic['redirect_count']}}</td>
                    <td>{{$statistic['award']}}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <th scope="row">Σ {{$total}}</th>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection