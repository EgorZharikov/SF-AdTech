@extends('layouts.dashboard')

@section('sidebar')
    @include('includes.dashboard.webmaster.sidebar')
@endsection

@section('title')
    <h3 class="mb-0">Wallet</h3>
@endsection

@section('content')
    <div class="container text-center">
        <div class="row align-items-start">
                <div class="col-sm-3 m-3">
                    <div class="card" style="width: 20rem;">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item text-success">Balance: {{$wallet->balance}} ₽
                            </li>
                        </ul>
                        <div class="card-body d-flex justify-content-center">
                            <a href=""
                                class="btn btn-primary me-3">Withdraw</a>
                            <form method="post" action="">
                                @csrf
                                <input type="hidden" name="offer_id" value="">
                                <button type=submit" class="btn btn-primary px-4">Replenish</button>
                            </form>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
