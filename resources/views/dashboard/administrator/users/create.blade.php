@extends('layouts.dashboard')

@section('sidebar')
    @include('includes.dashboard.administrator.sidebar')
@endsection

@section('title')
    <h3 class="mb-0">Users</h3>
@endsection

@section('content')
    <div class="container">
        <div class="col-md-4 offset-md-4 p-3 border">
            <h4 class="mb-3 text-primary">Add user in system:</h4>
            <div class="row align-items-center">
                <form method="post" action="{{ route('dashboard.administrator.users.store') }}">
                @csrf
                <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" value="{{old('name')}}" name="name" id="name" aria-describedby="emailHelp">
                        <div class="form-text text-danger">@error('name') {{$message}} @enderror</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" value="{{old('email')}}" name="email" id="email" aria-describedby="emailHelp">
                        <div class="form-text text-danger">@error('email') {{$message}} @enderror</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" value="{{old('password')}}" class="form-control" id="password">
                        <div class="form-text text-danger">@error('password') {{$message}} @enderror</div>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Select role</label>
                        <select id="role" name="role_id" class="form-select">
                            <option value="1">advertiser</option>
                            <option value="2">webmaster</option>
                            <option value="3">administrator</option>
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" type="hidden" name="email_verified_at" class="form-check-input" id="verificated" value="0">
                        <input type="checkbox" name="email_verified_at" class="form-check-input" id="verificated" value="1" checked>
                        <label class="form-check-label" for="verificated">Verificated</label>
                    </div>
                    <div class="d-grid">
                    <button type="submit" name="add_user" class="btn btn-primary">Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
