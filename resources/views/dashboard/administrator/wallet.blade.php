@extends('layouts.dashboard')

@section('sidebar')
    @include('includes.dashboard.administrator.sidebar')
@endsection

@section('title')
    <h3 class="mb-0">System wallets</h3>
@endsection

@section('content')
    <div class="container text-center">
        <div class="col-sm-4">
            <h4 class="mb-3 text-primary">System wallet (total in system):</h4>
            <div class="row align-items-center">
                <table class="table border">
                    <thead>
                        <tr>
                            <th scope="col" class="text-success">{{ $wallet->balance }} ₽</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="container text-center mt-3">
        <div class="col-sm-4">
            <h4 class="mb-3 text-primary">System income:</h4>
            <div class="row align-items-center">
                <table class="table border">
                    <thead>
                        <tr>
                            <th scope="col" class="text-success">{{ $walletIncome->balance }} ₽</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
