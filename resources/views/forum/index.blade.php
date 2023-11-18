@extends('layout.index')
@section('title', 'Forum')
@section('forum', 'active')
@section('page', 'Forum')
@section('subpage', '+ tambah forum')
@section('sublink', '/forum/tambah')
@section('content')
        <p>Jumlah Data {{ $jumlahForum }}</p>
        <p>Jumlah Komen {{ $jumlahKomentar }}</p>
        @foreach ($forum as $item)
        <div class="container-fluid d-flex flex-column mb-5" style="gap:20px ">
            <div class="rounded-3 border-secondary p-3" style="background-color: #f1f1f1">
                <div class="d-flex align-items-end" style="gap: 10px">
                    <h4 style="font-weight: bold">{{ $item->judul }}</h4>
                    <h6>{{ $item->nama }} || {{ $item->tanggal_post }}</h6>
                </div>
                <div class="col-12 text-truncate">{{ $item->content }}</div>
                <div>
                @foreach ($komentar as $komen)
                    @if ($item->id_forum == $komen->id_forum)
                        <div class="card-top">
                            <div class="mt-3">
                                <h5 class="fs-6 fw-bold">
                                    <h6>{{ $komen->username }} || {{ $komen->tanggal_post }}</h6>
                                    <h6>{{ $komen->komentar }}</h6>
                                </h5>
                            </div>
                        </div>
                    @endif
                @endforeach
                </div>
                <div>
                    <h6 class="text-end mt-2">
                        <a style="color:#00A9AD;text-decoration: underline" href="/forum/{{ $item->id_forum }}">
                            lihat forum >
                        </a>
                    </h6>
                </div>
            </div>
    </div>
    @endforeach
    </div>
@endsection
