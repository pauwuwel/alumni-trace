@extends('layout.index')
@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('page', 'dashboard')
@section('content')

    <head>
        <style>
            .text-karir {
                color: white;
                margin-top: 4%;
                font-size: 20px;
                text-align: center;
            }

            .jumlah-karir {
                color: white;
                font-size: 30px;
                text-align: center;
                font-weight: bold;
            }
        </style>
    </head>
    <div class="d-flex justify-content-between" style="gap: 12px">
        <div style="height: 20vh;background: #00AD83" class="box w-100 rounded">
            <p class="text-karir">KULIAH</p>
            <p class="jumlah-karir">875</p>
        </div>
        <div style="height: 20vh;background: #168DA7" class="box w-100 rounded">
            <p class="text-karir">WIRAUSAHA</p>
            <p class="jumlah-karir">200</p>
        </div>
        <div style="height: 20vh;background: #00A9AD" class="box w-100 rounded">
            <p class="text-karir">KERJA</p>
            <p class="jumlah-karir">900</p>
        </div>
    </div>
@endsection
