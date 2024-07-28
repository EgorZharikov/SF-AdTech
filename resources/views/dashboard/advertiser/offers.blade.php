@extends('layouts.dashboard')

@section('sidebar')
    @include('includes.dashboard.advertiser.sidebar')
@endsection

@section('title')
    <h3 class="mb-0">Offers</h3>
@endsection

@section('content')
    <div class="container text-center">
        <div class="row align-items-start">
            @foreach ($offers as $offer)
                <div class="col-sm-3 m-3">
                    <div class="card" style="width: 20rem;">
                        <img src="{{ asset('storage/' . $offer->preview_image) }}" class="card-img-top" alt="preview_image">
                        <div class="card-body">
                            <h5 class="card-title">{{ $offer->title }}</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item text-success">Redirection award: {{ $offer->award }}₽</li>
                            <li class="list-group-item">Topic: {{ $offer->topic->name }}</li>
                            <li class="list-group-item text-primary">Id: {{ $offer->id }}</li>
                        </ul>
                        <div class="card-body">
                            <a href="{{ route('offer.show', $offer->id) }}" class="btn btn-primary">Explore</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
