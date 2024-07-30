@extends('layouts.dashboard')

@section('sidebar')
@include('includes.dashboard.webmaster.sidebar')
@endsection

@section('title')
<h3 class="mb-0">Subscriptions</h3>
@endsection

@section('content')
<div class="container text-center">
    <div class="row align-items-start">
        @foreach ($subscriptions as $subscription)
        <div class="col-sm-3 m-3">
            <div class="card" style="width: 20rem;">
                <div class="card-body">
                    <h5 class="card-title">{{ $subscription->offer->title }}</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item text-success">Redirection award: {{ $subscription->offer->award }}₽
                    </li>
                    <li class="list-group-item">Topic: {{ $subscription->offer->topic->name }}</li>
                    @if($subscription->offer->status == 1)
                    <li class="list-group-item text-success">Status: active </li>
                    @else
                    <li class="list-group-item text-warning">Status: suspend </li>
                    @endif
                    <li class="list-group-item text-primary">Referal link: {{ url('redirect/' . $subscription->referal_link) }}</li>
                </ul>
                <div class="card-body d-flex justify-content-center">
                    <a href="{{ route('offer.show', $subscription->offer->id) }}" class="btn btn-primary me-3">Explore</a>
                    <form method="post" action="{{ route('offer.subscription.destroy', $subscription->offer->id) }}">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="offer_id" value="{{ $subscription->offer->id }}">
                        <button type=submit" class="btn btn btn-dark px-4">Unsubscribe</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection