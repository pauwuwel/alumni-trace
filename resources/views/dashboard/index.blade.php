@extends('layout.index')
@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('page', 'dashboard')
@section('content')
<head>
    <style>
        .text-karir {
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
            margin-top: 4%;
        }

        .jumlah-karir {
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            font-size: 30px;
            margin-top: 4%;
        }
    </style>
</head>
    <div class="row">
        <div class="d-flex justify-content-between" style="gap: 12px">
            <div style="height: 20vh;background: #00AD83" class="box w-100 rounded">
                <p class="text-karir">KULIAH</p>
                <p class="jumlah-karir">228</p>
            </div>
            <div style="height: 20vh;background: #168DA7" class="box w-100 rounded">
                <p class="text-karir">WIRAUSAHA</p>
                <p class="jumlah-karir">28</p>
            </div>
            <div style="height: 20vh;background: #00A9AD" class="box w-100 rounded">
                <p class="text-karir">KERJA</p>
                <p class="jumlah-karir">109</p>
            </div>
        </div>
    </div>
@endsection