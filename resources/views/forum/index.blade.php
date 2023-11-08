@extends('layout.index')
@section('title', 'Forum')
@section('forum', 'active')
@section('page', 'Forum')
@section('subpage', '+ tambah forum')
@section('sublink', '/forum/tambah')
@section('content')


    <div class="container-fluid d-flex flex-column mb-5" style="gap:20px">
        <p>Jumlah Forum {{ $jumlahForum }}</p>
        @foreach ($datas as $item)
            <div class="rounded-3  border-secondary p-3" style="background-color: #F1F1F1">  
                <div class="d-flex align-items-end" style="gap: 10px">
                    <h4 style="font-weight: bold">{{ $item->judul }}</h4>
                    <h6>{{ $item->nama }} || {{ $item->tanggal_post }}</h6>
                </div>
                <div class="col-12 text-truncate">{{ $item->content }}</div>
                <h6 class="text-end mt-2">
                    <a style="color:#00A9AD;text-decoration: underline" href="/forum/{{ $item->id_forum }}">
                        lihat forum
                    </a>
                </h6>
            </div>
        @endforeach
    </div>



@endsection
