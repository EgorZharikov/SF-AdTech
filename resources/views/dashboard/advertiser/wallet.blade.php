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
                        <h4>Balance: {{$wallet->balance}} ₽</h4>
                    </li>
                </ul>
                <div class="card-body d-flex justify-content-center" style="width: 20rem;">
                    <input type="number" class="form-control px-5" aria-label="Amount" name="award" value="" step="1" pattern="\d*">
                </div>
                <div class="card-body d-flex justify-content-center">
                    <form method="post" action="">
                        @csrf
                        <input type="hidden" name="offer_id" value="">
                        <button type="submit" class="btn btn-outline-success px-4 me-4">Replenish</button>
                    </form>
                    <a href="" class=" btn btn-outline-success">Withdraw</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection