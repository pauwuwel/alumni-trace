@extends('layout.index')
@section('title', 'Profile')
@section('page', 'Profile')
@section('content')
    <div class="row">
        @foreach ($datas as $data)
            <div style="gap: 10px" class="col-md-3 d-flex flex-column align-items-center">
                <img id="profile-image" src="{{ $data->foto !== null ? url('img/' . $data->foto) : url('img/pp.png') }}" class="w-100" alt="pp">
                <div class="d-flex w-100 justify-content-center" style="gap: 10px;">
                    @if ($data->id_akun == auth()->user()->id_akun)
                        <a href="/profile/edit/{{ $data->id_akun }}">
                            <button class="btn btn-info text-white">Edit Profile</button>
                        </a>
                    @endif
                    <button onClick="kembali()" class="btn btn-secondary">Kembali</button>
                </div>
            </div>
            <div class="col-md-9">
                <div class="d-flex flex-column" style="gap: 11px">
                    @if ($data->role == 'admin' || $data->role == 'admin')
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" disabled name="nama" id="nama" placeholder="Masukan nama" value="{{ $data->nama !== null ? $data->nama : '-' }}">
                        </div>
                    @elseif ($data->role == 'alumni')
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" disabled name="nama" id="nama" placeholder="Masukan nama" value="{{ $data->nama !== null ? $data->nama : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggalLahir">Tanggal Lahir</label>
                            <input type="text" class="form-control" disabled name="tanggal_lahir" id="tanggalLahir" placeholder="Masukan tanggal lahir" value="{{ $data->tanggal_lahir !== null ? $data->tanggal_lahir : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="jenKel">Jenis Kelamin</label>
                            <input type="text" class="form-control text-capitalize" disabled name="jenis_kelamin" id="jenKel" value="{{ $data->jenis_kelamin !== null ? $data->jenis_kelamin : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="notelp">Nomor Telepon</label>
                            <input type="text" class="form-control" disabled name="nomor_telepon" id="notelp" placeholder="Masukan nomor telepon" value="{{ $data->nomor_telepon !== null ? $data->nomor_telepon : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" disabled name="alamat" id="alamat" placeholder="Masukan alamat" value="-">
                        </div>
                        <div class="form-group">
                            <label for="karir">Riwayat Karir</label>
                            <input type="text" class="form-control" disabled name="karir" id="karir" placeholder="Masukan karir" value="-">
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <script>
        function kembali() {
            window.history.back();
        }
    </script>
@endsection
