@extends('layouts.dashboard')

@section('sidebar')
@include('includes.dashboard.administrator.sidebar')
@endsection

@section('title')
<h3 class="mb-0">Administrator</h3>
@endsection

@section('content')
    <div class="container text-center">
        <div class="row align-items-start">
            <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Name</h6>
                </div>
                <div class="col-sm-9 text-secondary">{{$user->name}}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Email</h6>
                </div>
                <div class="col-sm-9 text-secondary">{{$user->email}}</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Role</h6>
                </div>
                <div class="col-sm-9 text-secondary">administrator</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Registration date</h6>
                </div>
                <div class="col-sm-9 text-secondary">{{$user->created_at}}</div>
            </div>
        </div>
    </div>
        </div>
    </div>
    
@endsection