@extends('layout.index')
@section('title', 'Profile')
@section('page', 'Profile')
@section('style')
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
@endsection
@section('content')
    <form method="POST" action="" class="form row" enctype="multipart/form-data">
        @foreach ($profile as $data)
            <div style="gap: 10px" class="col-md-3 d-flex flex-column align-items-center">
                <img id="profile-image" style="cursor: pointer;"
                    src="{{ $data->foto !== null ? url('img/' . $data->foto) : url('img/pp.png') }}" class="w-100"
                    alt="pp">
                <input type="file" name="foto" id="file-input" accept="image/*" style="display: none">
                <input type="hidden" name="role" value="{{ $data->role }}">
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
                    @if ($data->role == 'superAdmin')
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama"
                                placeholder="Masukan nama" value="{{ $data->nama }}">
                            <input type="hidden" name="id_super_admin" value="{{ $data->id_super_admin }}">
                        </div>
                    @elseif ($data->role == 'admin')
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama"
                                placeholder="Masukan nama" value="{{ $data->nama }}">
                            <input type="hidden" name="id_admin" value="{{ $data->id_admin }}">
                        </div>
                    @elseif ($data->role == 'alumni')
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" required class="form-control" name="nama" id="nama"
                                placeholder="Masukan nama" value="{{ $data->nama }}">
                            <input type="hidden" name="id_alumni" value="{{ $data->id_alumni }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggalLahir">Tanggal Lahir</label>
                            <input type="date" required class="form-control" name="tanggal_lahir" id="tanggalLahir"
                                placeholder="Masukan tanggal lahir" value="{{ $data->tanggal_lahir }}">
                        </div>
                        <div class="form-group">
                            <label for="jenKel">Jenis Kelamin</label>
                            <select required class="form-select" name="jenis_kelamin" id="jenKel">
                                <option selected value="" hidden>Pilih Jenis Kelamin</option>
                                <option value="laki-laki" {{ $data->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>
                                    Laki-Laki</option>
                                <option value="perempuan" {{ $data->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notelp">Nomor Telepon</label>
                            <input type="number" required class="form-control hide-arrows" name="nomor_telepon"
                                id="notelp" placeholder="Masukan nomor telepon" value="{{ $data->nomor_telepon }}">
                        </div>
                        <div>
                            <label for="alamat">Alamat</label>
                            @foreach ($alamat as $data)
                                <div class="form-group">
                                    <div class="d-flex flex-column" style="gap: 11px;">
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="text-muted" for="jalan">Jalan</label>
                                                <input type="text" class="form-control" name="jalan" id="jalan"
                                                    placeholder="Masukan jalan" value="{{ $data->jalan }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="text-muted" for="gang">Gang</label>
                                                <input type="text" class="form-control" name="gang" id="gang"
                                                    placeholder="Masukan gang" value="{{ $data->gang }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="text-muted" for="nomor_rumah">Nomor Rumah</label>
                                                        <input type="text" class="form-control" name="nomor_rumah"
                                                            id="nomor_rumah" placeholder="Nomor Rumah"
                                                            value="{{ $data->nomor_rumah }}">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="text-muted" for="blok">Blok</label>
                                                        <input type="text" class="form-control" name="blok"
                                                            id="blok" placeholder="Blok"
                                                            value="{{ $data->blok }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="text-muted" for="rt">RT</label>
                                                        <input type="text" class="form-control" name="rt"
                                                            id="rt" placeholder="RT" value="{{ $data->rt }}">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="text-muted" for="rw">RW</label>
                                                        <input type="text" class="form-control" name="rw"
                                                            id="rw" placeholder="RW" value="{{ $data->rw }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="text-muted" for="kelurahan">Kelurahan</label>
                                                <input type="text" class="form-control" name="kelurahan"
                                                    id="kelurahan" placeholder="Masukan kelurahan"
                                                    value="{{ $data->kelurahan }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="text-muted" for="kecamatan">Kecamatan</label>
                                                <input type="text" class="form-control" name="kecamatan"
                                                    id="kecamatan" placeholder="Masukan kecamatan"
                                                    value="{{ $data->kecamatan }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <label class="text-muted" for="kota">Kota</label>
                                                <input type="text" class="form-control" name="kota" id="kota"
                                                    placeholder="Masukan kota" value="{{ $data->kota }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="text-muted" for="kodepos">Kodepos</label>
                                                <input type="text" class="form-control" name="kodepos" id="kodepos"
                                                    placeholder="Masukan kodepos" value="{{ $data->kodepos }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
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
