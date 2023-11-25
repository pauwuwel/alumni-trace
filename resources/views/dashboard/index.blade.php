@extends('layout.index')
@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('page', 'dashboard')
@section('style')
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

        .table-responsive {
            overflow: hidden;
        }

        .table thead th {
            position: sticky;
            top: 0;
            background-color: #fff;
            /* Set a background color to make it stand out */
            z-index: 1;
            /* Ensure it's above the scrolling content */
        }

        .karirCard {
            background-repeat: no-repeat;
            background-position: center;
            background-blend-mode: overlay;
        }

        .karirKuliah {
            background-color: #168DA7;
            background-size: 100px;
            background-image: url({{ url('img/mortar.png') }});
        }

        .karirKerja {
            background-color: #00AD83;
            background-size: 108px;
            background-image: url({{ url('img/manii.png') }});
        }

        .karirWirausaha {
            background-color: #00A9AD;
            background-size: 112px;
            background-image: url({{ url('img/henseks.png') }});
        }

    </style>
@endsection
@section('content')
    <div class="d-flex justify-content-between flex-column flex-md-row" style="gap:10px">
        <div class="w-100 d-flex flex-column align-items-center justify-content-center rounded py-4 text-white karirCard karirKuliah">
            <h3 style="letter-spacing: 2px; margin-bottom: 0px">Kuliah</h3>
            <h2 class="fw-bold" style="letter-spacing: 1px; margin-bottom: 0px">{{ $karir_data->total_kuliah }}</h2>
        </div>
        <div class="w-100 d-flex flex-column align-items-center justify-content-center rounded py-4 text-white karirCard karirKerja">
            <h3 style="letter-spacing: 2px; margin-bottom: 0px">Kerja</h3>
            <h2 class="fw-bold" style="letter-spacing: 1px; margin-bottom: 0px">{{ $karir_data->total_kerja }}</h2>
        </div>
        <div class="w-100 d-flex flex-column align-items-center justify-content-center rounded py-4 text-white karirCard karirWirausaha">
            <h3 style="letter-spacing: 2px; margin-bottom: 0px">Wirausaha</h3>
            <h2 class="fw-bold" style="letter-spacing: 1px; margin-bottom: 0px">{{ $karir_data->total_wirausaha }}</h2>
        </div>
    </div>
@endsection
