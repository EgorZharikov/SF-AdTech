@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg">
        <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
            <h1 class="display-7 fw-bold lh-1">{{ $offer->title }}</h1>
            <p class="lead">{{ $offer->content }}</p>
            <div class="col-md-5 col-lg-5 p-1 mb-4">
                <div class="alert alert-success p-2" role="alert">
                    <div class="list-group-item d-flex justify-content-between">
                        <strong>Redirection award:</strong>
                        <strong>{{ $offer->award }} ₽</strong>
                    </div>
                </div>
                <div class="alert alert-secondary p-2" role="alert">
                    <div class="list-group-item d-flex justify-content-between">
                        <strong>Topic:</strong>
                        <strong>{{ $offer->topic->name }}</strong>
                    </div>
                </div>
                @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{$errors->first()}}
                </div>
                @endif
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                @can('subscribe', $offer)
                <form method="post" action="{{ route('offer.subscription.store', $offer->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg px-4 me-md-2 fw-bold">Subscribe</button>
                </form>
                @endcan
                @can('unsubscribe', $offer)
                <form method="post" action="{{ route('offer.subscription.destroy', $offer->id) }}">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                    <button type=submit" class="btn btn btn-dark btn-lg px-4">Unsubscribe</button>
                </form>
                @endcan
                @can('update', $offer)
                <a href="{{ route('offer.edit', $offer->id) }}" class="btn btn-primary btn-lg px-4 me-3">Edit</a>
                @endcan
                @can('unpublish', $offer)
                <form method="post" action="{{ route('offer.unpublish', $offer->id) }}">
                    @csrf
                    @method('patch')
                    <button type=submit" class="btn btn btn-dark btn-lg px-4 me-3">Unpublish</button>
                </form>
                @endcan
                @can('publish', $offer)
                <form method="post" action="{{ route('offer.publish', $offer->id) }}">
                    @csrf
                    @method('patch')
                    <button type=submit" class="btn btn btn-success btn-lg px-4">Publish</button>
                </form>
                @endcan

            </div>
        </div>
        <div class="col-lg-3 offset-lg-1 p-0 overflow-hidden shadow-lg">
            <img class="rounded-lg-3" src="{{ asset('storage/' . $offer->preview_image) }}" alt="" width="324">
        </div>
    </div>
</div>
@endsection