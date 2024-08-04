@extends('layouts.app')

@section('content')
<div class="container">
    <main>
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="/img/creation_offer.png" alt="" width="120">
            <h2>Creation of a new advertising offer</h2>
            <p class="lead">Fill the required fields to create an advertising offer.</p>
        </div>

        <div class="row g-5">
            <div class="col-md-5 col-lg-4 order-md-last">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Your wallet</span>
                </h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (₽)</span>
                        <strong> {{$wallet->balance}} </strong>
                    </li>
                </ul>
                @if($errors->has('walletError'))
                <div class="alert alert-danger" role="alert">
                    Insufficient funds! <a href="{{url('advertiser/wallet')}}">Please spread the word to help raise the balance.</a>
                </div>
                @endif
            </div>
            <div class="col-md-7 col-lg-8">
                <form class="needs-validation" action="{{ route('offer.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="title" class="form-label">Title:</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title')}}" placeholder="Offer title" required>
                            <div class="form-text text-danger">@error('title') {{$message}} @enderror</div>
                        </div>
                        <div class="col-12">
                            <label for="url" class="form-label">Link to your website:</label>
                            <input type="url" class="form-control" value="{{ old('url')}}"  id="url" name="url" placeholder="https://example.com" required>
                           <div class="form-text text-danger">@error('url') {{$message}} @enderror</div>
                        </div>
                        <div class="col-12">
                            <label for="content" class="form-label">Main content:</label>
                            <textarea class="form-control" value="{{ old('content')}}" id="content" rows="10" name="content"></textarea>
                        <div class="form-text text-danger">@error('content') {{$message}} @enderror</div>
                        </div>
                        <div class="col-12">
                            <label for="topic" class="form-label">Topic:</label>
                            <input type="text" class="form-control" value="{{ old('topic')}}" id="topic" name="topic" placeholder="Enter topic your website" required>
                          <div class="form-text text-danger">@error('topic') {{$message}} @enderror</div>
                        </div>
                        <div class="col-12">
                            <span>Preview image:</span>
                            <div class="input-group mt-2">
                                <input type="file" class="form-control" id="preview_image" name="preview_image">
                            </div>
                            <div class="form-text text-danger">@error('preview_image') {{$message}} @enderror</div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <span>Reward:</span>
                            <div class="input-group mt-2">
                                <span class="input-group-text">₽</span>
                                <input type="number" class="form-control" value="{{ old('award')}}" aria-label="Amount" name="award" step=".1" pattern="\d*">
                            </div>
                            <div class="form-text text-danger">@error('award') {{$message}}@enderror</div>
                        </div>
                        <div class="col-12 mb-4">
                            <div class="form-check form-switch" style="display:contents;">
                                <label class="form-check-label me-3" for="uniqueIp"><strong>Unique ip:</strong></label>
                                <input class="form-check-input" type="hidden" value="0" id="uniqueIp" name="uniqueIp" style="float:none;margin-left:0.5rem;transform: scale(1.8);">
                                <input class="form-check-input" type="checkbox" value="1" id="uniqueIp" name="uniqueIp" style="float:none;margin-left:0.5rem;transform: scale(1.8);" checked>
                            </div>
                        </div>
                        <button class=" w-100 btn btn-primary btn-lg mb-4" type="submit">Create</button>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection