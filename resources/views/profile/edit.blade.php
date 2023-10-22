@extends('layout.index')
@section('title', 'Profile')
@section('page', 'Profile')
@section('content')
    <style>
        .change-profile-label {
            cursor: pointer;
            display: block;
            text-align: center;
            color: #000000;
            font-size: 14px;
        }
        .hide-arrows::-webkit-outer-spin-button,
        .hide-arrows::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .hide-arrows {
            -moz-appearance: textfield;
        }
    </style>
    <form method="POST" action="" class="row">
        @foreach ($datas as $data)
            <div style="gap: 10px" class="col-md-3 d-flex flex-column align-items-center">
                <img id="profile-image" src="{{ $data->foto !== null ? url('img/' . $data->foto) : url('img/pp.png') }}" class="w-100" alt="pp">
                <input type="file" name="foto" id="file-input" accept="image/*" style="display: none">
                <label for="file-input" class="change-profile-label">Klik untuk mengubah foto profil</label>
                @csrf
                <div class="d-flex w-100 justify-content-center" style="gap: 10px;">
                    @if ($data->id_akun == auth()->user()->id_akun)
                        <button type="submit" class="btn btn-info text-white">Simpan Perubahan</button>
                    @endif
                    <button type="button" onClick="kembali()" class="btn btn-secondary">Kembali</button>
                </div>
            </div>
            <div class="col-md-9">
                <div class="d-flex flex-column" style="gap: 11px">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukan nama" value="{{ $data->nama }}">
                    </div>
                    <div class="form-group">
                        <label for="tanggalLahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tanggal_lahir" id="tanggalLahir" placeholder="Masukan tanggal lahir" value="{{ $data->tanggal_lahir }}">
                    </div>
                    <div class="form-group">
                        <label for="jenKel">Jenis Kelamin</label>
                        <select class="form-select" id="jenKel">
                            <option selected hidden>Pilih Jenis Kelamin</option>
                            <option value="laki-laki" {{ $data->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="perempuan" {{ $data->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <!-- <input type="text" class="form-control" name="jenis_kelamin" id="jenKel" value="{{ $data->jenis_kelamin }}"> -->
                    </div>
                    <div class="form-group">
                        <label for="notelp">Nomor Telepon</label>
                        <input type="number" class="form-control hide-arrows" name="nomor_telepon" id="notelp" placeholder="Masukan nomor telepon" value="{{ $data->nomor_telepon }}">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukan alamat" disabled value="-">
                    </div>
                    <div class="form-group">
                        <label for="karir">Riwayat Karir</label>
                        <input type="text" class="form-control" name="karir" id="karir" placeholder="Masukan karir" disabled value="-">
                    </div>
                </div>
            </div>
        @endforeach
    </form>
    <script>

        function kembali() {
            window.history.back();
        }
        document.getElementById("profile-image").addEventListener("click", function() {
            document.getElementById("file-input").click();
        });

        document.getElementById("file-input").addEventListener("change", function() {
            const selectedFile = this.files[0];
            if (selectedFile) {
                const profileImage = document.getElementById("profile-image");
                const url = URL.createObjectURL(selectedFile);
                profileImage.src = url;
            }
        });
    </script>
@endsection