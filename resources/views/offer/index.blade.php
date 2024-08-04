@extends('layouts.app')
@section('content')
    <div class="container text-center">
        <div class="row align-items-start">
            @if ($user->role_id == 1)
                <div class="mb-3">
                    <a href="{{ route('offer.create') }}" class="btn btn-primary">Create offer</a>
                </div>
                <hr>
            @endif
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
                        </ul>
                        <div class="card-body">
                            <a href="{{ route('offer.show', $offer->id) }}" class="btn btn-primary">Explore</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $offers->links() }}
    </div>
@endsection
