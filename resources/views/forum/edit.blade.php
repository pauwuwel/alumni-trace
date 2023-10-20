@extends('layout.index')
@section('title', 'Forum')
@section('forum', 'active')
@section('page', 'Forum')
@section('subpage', '+ tambah forum')
@section('content')
    <div class="container-fluid d-flex flex-column">
        @foreach ($datas as $item)
            <div class="rounded-3 shadow p-4">
                <div class="d-flex align-items-end" style="gap: 10px">
                    <h4 style="font-weight: bold">{{ $item->judul }}</h4>
                    <h6>tanskyyyyyy || {{ $item->tanggal_post }}</h6>
                </div>
                <div class="col-12 text-truncate">{{ $item->content }}</div>
                <h6 class="text-end mt-2">
                    <a style="color:#00A9AD;text-decoration: underline" href="#">
                        lihat forum
                    </a>
                </h6>
            </div>
        @endforeach
    </div>
@endsection
