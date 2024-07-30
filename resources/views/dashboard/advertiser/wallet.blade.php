@extends('layouts.dashboard')

@section('sidebar')
    @include('includes.dashboard.advertiser.sidebar')
@endsection

@section('title')
    <h3 class="mb-0">Wallet</h3>
@endsection

@section('content')
    <div class="container text-center">
        <div class="row align-items-start">
            <div class="col-sm-3 m-3">
                <div class="card d-flex justify-content-center bg-dark" style="width: 20rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-bg-success">
                            <h4>Balance: {{ $wallet->balance }} ₽</h4>
                        </li>
                    </ul>
                    <form method="post" action="{{ route('wallet.update') }}">
                        @csrf
                        @method('patch')
                        <div class="card-body d-flex justify-content-center" style="width: 20rem;">
                            <input type="number" class="form-control px-5" aria-label="Amount" name="amount"
                                value="" step="1" pattern="\d*">
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <button type="submit" name="replenish"
                                class="btn btn-outline-success px-4 me-4">Replenish</button>
                            <button type="submit" name="withdraw"
                                class="btn btn-outline-success px-4 me-4">Withdraw</button>
                        </div>
                    </form>
                </div>
            </div>
            @if($errors->has('walletError'))
            <div class="col-sm-3 m-3">
                <div class="alert alert-warning" role="alert">
                    {{$errors->first()}}
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
