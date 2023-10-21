@extends('layout.index')
@section('title', 'Galeri')
@section('gallery', 'active')
@section('page', 'Galeri')
@section('content')
    <div class="row">
        @foreach ($datas as $data)
            <div class="col-md-2 col-sm-12 mb-2">
                <a style="text-decoration:none;" href="/profile/{{ $data->id_akun }}">
                    <button class="card w-100 rounded-3 d-flex flex-column justify-content-between p-3 h-100">
                        <img src="{{ url('img/pp.png') }}" alt="pp" class="w-100 mb-2 rounded" srcset="">
                        <h4 class="text-capitalize text-bold w-100">{{ $data->nama }}</h4>
                    </button>
                </a>
            </div>
        @endforeach
    </div>
@endsection