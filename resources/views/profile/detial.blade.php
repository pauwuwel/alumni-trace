@extends('layout.index')
@section('title', 'Profile')
@section('page', 'Profile')
@section('content')
    <div class="row">
        <div style="gap: 10px" class="col-3 d-flex flex-column justify-content-center align-items-center">
            <img src="{{ url('img') . '/pp.png' }}" width="400" height="400" alt="pp">
            <div style="gap: 20px" class="d-flex">
                <a href="/profile/edit/{{ Auth::user()->id_akun }}">
                    <button class="btn btn-info text-white">Simpan Perubahan</button>
                </a>
                <a href="/profile/{{ Auth::user()->id_akun }}">
                    <button class="btn btn-secondary text-white">Kembali</button>
                </a>
            </div>
        </div>
        <div class="col-9">
            @if (Auth::user()->role == 'superAdmin')
                @foreach ($superAdmin as $item)
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="nama" class="form-control"  name="nama" id="nama" placeholder="Masukan nama" value="{{ $item->nama }}">
                    </div>
                @endforeach
            @elseif (Auth::user()->role == 'admin')
                @foreach ($admin as $item)
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="nama" class="form-control"  name="nama" id="nama" placeholder="Masukan nama" value="{{ $item->nama }}">
                    </div>
                @endforeach
            @elseif (Auth::user()->role == 'alumni')
                @foreach ($alumni as $item)
                    <div class="d-flex flex-column" style="gap: 11px">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control"  name="nama" id="nama" placeholder="Masukan nama" value="{{ $item->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggalLahir">Tanggal Lahir</label>
                            <input type="text" class="form-control"  name="tanggal_lahir" id="tanggalLahir" placeholder="Masukan tanggal lahir" value="{{ $item->tanggal_lahir !== null ? $item->tanggal_lahir : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="jenKel">Jenis Kelamin</label>
                            <input type="text" class="form-control"  name="jenis_kelamin" id="jenKel" value="{{ $item->jenis_kelamin !== null ? $item->jenis_kelamin : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="notelp">Nomor Telepon</label>
                            <input type="text" class="form-control"  name="nomor_telepon" id="notelp" placeholder="Masukan nomor telepon" value="{{ $item->nomor_telepon !== null ? $item->nomor_telepon : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control"  name="alamat" id="alamat" placeholder="Masukan alamat" value="{{ $item->jenis_kelamin !== null ? $item->jenis_kelamin : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="karir">Riwayat Karir</label>
                            <input type="text" class="form-control"  name="karir" id="karir" placeholder="Masukan karir" value="{{ $item->jenis_kelamin !== null ? $item->jenis_kelamin : '-' }}">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
