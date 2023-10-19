@extends('layout.index')
@section('title', 'Profile')
@section('page', 'Profile')
@section('content')
    <div class="row">
        <div style="gap: 10px" class="col-3 d-flex flex-column justify-content-center align-items-center">
            <img src="{{ url('img') . '/pp.png' }}" width="400" height="400" alt="pp">
            <div class="d-flex w-50 justify-content-between">
                    <a href="/profile/edit/">
                        <button class="btn btn-info text-white">Edit Profile</button>
                    </a>
                    <a href="/dashboard">
                        <button class="btn btn-secondary text-white">Kembali</button>
                    </a>
            </div>
        </div>
        <div class="col-9">
            @foreach ($data as $item)
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="nama" class="form-control" disabled name="nama" id="nama" placeholder="Masukan nama" value="{{ $item->nama }}">
                </div>
            @endforeach
        </div>
    </div>
@endsection
