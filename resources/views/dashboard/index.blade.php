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

        .chart-container {
            max-height: 240px;
        }

        #chartKarir {
            width: 200px !important;
            height: 200px !important;
        }

        .karirbox {
            width: 12px;
            height: 12px;
        }

        .karir-text p {
            margin: 0px !important;
        }

        .boxkuliah {
            background: #67C587;
        }

        .boxkerja {
            background: #C9EAD4;
        }

        .boxwirausaha {
            background: #EAF6ED;
        }

        .boxnganggur {
            background: #A9DEBA;
        }

        .table-scroll {
            max-height: 240px;
            overflow-y: auto;
        }
    </style>
@endsection
@section('content')
    <div class="d-flex flex-column" style="gap:16px">
        <div class="d-flex justify-content-between flex-column flex-md-row" style="gap:10px">
            <div
                class="w-100 d-flex flex-column align-items-center justify-content-center rounded py-5 text-white karirCard karirKuliah">
                <h3 style="letter-spacing: 2px; margin-bottom: 0px">Kuliah</h3>
                <h2 class="fw-bold" style="letter-spacing: 1px; margin-bottom: 0px">{{ $karir_data->total_kuliah }}</h2>
            </div>
            <div
                class="w-100 d-flex flex-column align-items-center justify-content-center rounded py-5 text-white karirCard karirKerja">
                <h3 style="letter-spacing: 2px; margin-bottom: 0px">Kerja</h3>
                <h2 class="fw-bold" style="letter-spacing: 1px; margin-bottom: 0px">{{ $karir_data->total_kerja }}</h2>
            </div>
            <div
                class="w-100 d-flex flex-column align-items-center justify-content-center rounded py-5 text-white karirCard karirWirausaha">
                <h3 style="letter-spacing: 2px; margin-bottom: 0px">Wirausaha</h3>
                <h2 class="fw-bold" style="letter-spacing: 1px; margin-bottom: 0px">{{ $karir_data->total_wirausaha }}</h2>
            </div>
        </div>
        <div class="d-flex justify-content-between flex-column flex-md-row" style="gap: 10px;">
            <div class="chart-container d-flex shadow p-4 justify-content-center rounded" style="gap:16px;">
                <canvas id="chartKarir"></canvas>
                <div class="d-flex flex-column align-items-start justify-content-around">
                    <div class="d-flex align-items-center karir-text" style="gap: 8px;">
                        <div class="karirbox boxkuliah"></div>
                        <p>Kuliah</p>
                    </div>
                    <div class="d-flex align-items-center karir-text" style="gap: 8px;">
                        <div class="karirbox boxkerja"></div>
                        <p>Kerja</p>
                    </div>
                    <div class="d-flex align-items-center karir-text" style="gap: 8px;">
                        <div class="karirbox boxwirausaha"></div>
                        <p>Wirausaha</p>
                    </div>
                    <div class="d-flex align-items-center karir-text" style="gap: 8px;">
                        <div class="karirbox boxnganggur"></div>
                        <p>Tidak diketahui</p>
                    </div>
                </div>
            </div>
            {{-- @if (auth()->user()->role == 'superAdmin') --}}
                <div class="table-scroll w-100 shadow rounded">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td style="text-align: center;">Riwayat Aktivitas</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($log_data as $logs)
                                <tr>
                                    <td class="text-{{ $logs->action == 'INSERT' ? 'success' : ( $logs->action == 'UPDATE' ? 'warning' : ( $logs->action == 'DELETE' || $logs->action == 'REJECT' ? 'danger' : (  $logs->action == 'ACCEPT' ? 'info' : '' ) ) ) }}">
                                        {{ $logs->actor == auth()->user()->username ? 'Anda ' : $logs->actor }}
                                        {{ $logs->action == 'INSERT' ? 'membuat ' : ( $logs->action == 'UPDATE' ? 'mengedit ' : ( $logs->action == 'DELETE' ? 'menghapus ' : (  $logs->action == 'ACCEPT' ? 'mengkonfirmasi ' : ( $logs->action == 'REJECT' ? 'menolak ' : '' ) ) ) ) }}
                                        {{ $logs->table }}
                                        {{ 'dengan id ' . $logs->row . ' || ' }}
                                        {{ $logs->date }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted">Tidak ada log yang tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            {{-- @elseif(auth()->user()->role == 'admin')
                <div class="table-scroll w-100 shadow rounded">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td style="text-align: center;" colspan="2">Konfirmasi Forum Alumni</td>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($forum_data as $forum)
                                <tr>
                                    <td style="width: 90%">
                                        @if ($forum !== null)
                                            {{ $forum->nama_pembuat }}, <b>{{ $forum->judul }}</b>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($forum !== null)
                                            <a style="text-decoration: none" href="/forum/post/{{ $forum->id_forum }}">
                                                <button class="btn btn-warning">Detail</button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-muted">Tidak ada forum yang tersedia</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div> --}}
            {{-- @endif --}}
        </div>
    </div>

    <script type="module">
        var ctx = document.getElementById('chartKarir').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Kuliah', 'Kerja', 'Wirausaha', 'Tidak Diketahui'],
                datasets: [{
                    label: 'Total alumni',
                    data: [
                        {{ $karir_data->total_kuliah }},
                        {{ $karir_data->total_kerja }},
                        {{ $karir_data->total_wirausaha }},
                        {{ $karir_data->total_nganggur }}
                    ],
                    backgroundColor: ['#67C587', '#C9EAD4', '#EAF6ED', '#A9DEBA'],
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        display: false,
                    }
                },
            }
        });
    </script>
@endsection
