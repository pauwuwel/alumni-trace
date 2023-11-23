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
    </style>
@endsection
@section('content')
    <div class="row">
        @if (auth()->user()->role == 'superAdmin')
            <div class="col-md-4 d-flex flex-column align-items-center justify-content-center" style="height: 20vh">
                <h2>Total Alumni:</h2>
                <h1>{{ $totalAlumni }}</h1>
            </div>
            <div class="col-md-5 shadow rounded-3" style="height: 35vh; overflow-x: auto;">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Konfirmasi Forum Alumni</th>
                            <!-- Add more th elements for additional columns if needed -->
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($accForum))
                            @foreach ($accForum as $forum)
                                <tr>
                                    <td>{{ $forum->nama }}, <b>{{ $forum->judul }}</b></td>
                                    <!-- Add more td elements for additional columns if needed -->
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        @elseif (auth()->user()->role == 'admin')
            <div class="col-md-5 shadow rounded-3" style="height: 35vh; overflow-x: auto;">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <td style="text-align: center" colspan="2">Konfirmasi Forum Alumni</td>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($accForum))
                            @foreach ($accForum as $forum)
                                <tr>
                                    <td style="width: 90%">{{ $forum->nama }}, <b>{{ $forum->judul }}</b></td>
                                    <td>
                                        <a style="text-decoration: none" href="/forum/post/{{ $forum->id_forum }}"><button
                                                class="btn btn-warning">Detail</button></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        @elseif (auth()->user()->role == 'alumni')
            {{-- <div class="row">
                <div class="d-flex justify-content-between" style="gap: 12px">
                    <div style="height: 20vh;background: #00AD83" class="box w-100 rounded">
                        <p class="text-karir">KULIAH</p>
                        <p class="jumlah-karir">1</p>
                    </div>
                    <div style="height: 20vh;background: #168DA7" class="box w-100 rounded">
                        <p class="text-karir">WIRAUSAHA</p>
                        <p class="jumlah-karir">0</p>
                    </div>
                    <div style="height: 20vh;background: #00A9AD" class="box w-100 rounded">
                        <p class="text-karir">KERJA</p>
                        <p class="jumlah-karir">0</p>
                    </div>
                </div>
            </div> --}}
        @endif
    </div>
@endsection
