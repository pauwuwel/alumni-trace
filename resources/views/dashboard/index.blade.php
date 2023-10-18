@extends('layout.index')
@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('page', 'dashboard')
@section('content')
<head>
    <style>
        .text-karir {
            color: white;
            margin-top: 10%;
            font-size: 20px;
            text-align: center;
        }
    </style>
</head>
    <div class="d-flex justify-content-between" style="gap: 12px">
        <div style="height: 20vh;background: #00AD83" class="box w-100 rounded">
            <p class="text-karir">KULIAH</p>
        </div>
        <div style="height: 20vh;background: #168DA7" class="box w-100 rounded">
            <p class="text-karir">WIRAUSAHA</p>
        </div>
        <div style="height: 20vh;background: #00A9AD" class="box w-100 rounded">
            <p class="text-karir">KERJA</p>
        </div>
    </div>
    {{-- <div class="row">
        <div class="card col-md-4">
            <div class="card-header"></div>
            <div class="card-body"></div>
        </div>
    </div> --}}
@endsection