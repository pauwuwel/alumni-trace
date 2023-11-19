@extends('layout.index')
@section('title', 'Profile')
@section('page', 'Profile')
@section('style')
    <style>

        .hr-container {
            display: flex;
            align-items: center;
            text-align: center;
        }

        .hr-container hr {
            flex: 1;
            margin: 0;
        }

        .hr-container .text {
            padding: 0 10px;
            color: #888;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        @foreach ($profile as $data)
            <div style="gap: 10px" class="col-md-3 d-flex flex-column align-items-center">
                <img id="profile-image" src="{{ $data->foto !== null ? url('img/' . $data->foto) : url('img/pp.png') }}"
                    class="w-100" alt="pp">
                <div class="d-flex w-100 justify-content-center" style="gap: 10px;">
                    @if ($data->id_akun == auth()->user()->id_akun)
                        <a href="/profile/edit/{{ $data->id_akun }}">
                            <button class="btn btn-info text-white">Edit Profile</button>
                        </a>
                    @endif
                    <button type="button" onClick="kembali()" class="btn btn-secondary">Kembali</button>
                </div>
            </div>
            <div class="col-md-9">
                <div class="d-flex flex-column" style="gap: 11px">
                    @if ($data->role == 'superAdmin' || $data->role == 'admin')
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" disabled name="nama" id="nama"
                                value="{{ $data->nama !== null ? $data->nama : '-' }}">
                        </div>
                    @elseif ($data->role == 'alumni')
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" disabled name="nama" id="nama"
                                value="{{ $data->nama !== null ? $data->nama : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggalLahir">Tanggal Lahir</label>
                            <input type="text" class="form-control" disabled name="tanggal_lahir" id="tanggalLahir"
                                value="{{ $data->tanggal_lahir !== null ? $data->tanggal_lahir : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="jenKel">Jenis Kelamin</label>
                            <input type="text" class="form-control text-capitalize" disabled name="jenis_kelamin"
                                id="jenKel" value="{{ $data->jenis_kelamin !== null ? $data->jenis_kelamin : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="notelp">Nomor Telepon</label>
                            <input type="text" class="form-control" disabled name="nomor_telepon" id="notelp"
                                value="{{ $data->nomor_telepon !== null ? $data->nomor_telepon : '-' }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control" style="resize: none" disabled id="alamat" rows="5">{{ $data->jalan !== null ? 'Jalan ' . $data->jalan : '' }} {{ $data->gang !== null ? 'Gang ' . $data->gang : '' }} {{ $data->nomor_rumah !== null ? 'No. ' . $data->nomor_rumah : '' }} {{ $data->blok !== null ? 'Blok ' . $data->blok : '' }} {{ $data->rt !== null ? 'RT ' . $data->rt : '' }} / {{ $data->rw !== null ? 'RW ' . $data->rw : '' }} {{ $data->kelurahan !== null ? 'Kelurahan ' . $data->kelurahan : '' }} {{ $data->kecamatan !== null ? 'Kecamatan ' . $data->kecamatan : '' }} {{ $data->kota !== null ? 'Kota ' . $data->kota : '' }} {{ $data->kodepos !== null ? $data->kodepos : '' }} </textarea>
                        </div>
                    @endif
                    <div class="hr-container">
                        <hr class="my-4">
                        <span class="text-muted text">Riwayat Karir</span>
                        <hr class="my-4">
                    </div>
                    <div class="form-group">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td colspan="2">
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">Tambah Karir</button>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($career as $data)
                                    <tr>
                                        <td>
                                            {{ $data->tanggal_selesai !== null ? 'Telah ' : 'Sedang ' }}
                                            {{ $data->jenis_karir == 'kuliah' ? 'menjalankan kuliah di ' : 
                                                ($data->jenis_karir == 'kerja' ? 'bekerja pada ' : 
                                                ($data->jenis_karir == 'wirausaha' ? 'menjalankan usaha dengan nama ' : '')) 
                                            }}
                                            {{ $data->nama_instansi }}
                                            {{ $data->jenis_karir == 'kuliah' ? 'dengan jurusan ' : 
                                                ($data->jenis_karir == 'kerja' ? 'dengan jabatan ' : 
                                                ($data->jenis_karir == 'wirausaha' ? 'dalam bidang ' : '')) 
                                            }}
                                            {{ $data->posisi_bidang }}
                                            {{ $data->tanggal_selesai !== null ? 'pada ' : 'sejak ' }}
                                            {{ $data->tanggal_mulai }}
                                            {{ $data->tanggal_selesai !== null ? 'hingga ' . $data->tanggal_selesai : ' ' }}
                                            
                                        </td>
                                        <td style="width: 5%"><button class="btn btn-sm btn-info text-white">Edit</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Riwayat Karir</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="d-flex flex-column">
                            <div class="form-group">
                                <label for="jenis_karir">Pilih Jenjang Karir</label>
                                <select required class="form-control" name="jenis_karir" id="jenis_karir">
                                    <option selected value="" hidden>Pilih Karir</option>
                                    <option value="kuliah">Kuliah</option>
                                    <option value="kerja">Kerja</option>
                                    <option value="wirausaha">Wirausaha</option>
                                </select>
                            </div>
                            
                            <div id="kuliahForm" class="formKarir" style="display: none;">
                                <div class="form-group">
                                    <label for="nama_instansi">Instansi</label>
                                    <input type="text" class="form-control" name="nama_instansi" id="nama_instansi" placeholder="Masukan instansi">
                                </div>
                                <div class="form-group">
                                    <label for="posisi_bidang">Jurusan</label>
                                    <input type="text" class="form-control" name="posisi_bidang" id="posisi_bidang" placeholder="Masukan jurusan">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Lulus</label>
                                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" aria-describedby="selesaiHelp">
                                    <div id="selesaiHelp" class="form-text">Masukan jika perlu.</div>
                                </div>
                            </div>  
                            
                            <div id="kerjaForm" class="formKarir" style="display: none;">
                                <div class="form-group">
                                    <label for="nama_instansi">Instansi</label>
                                    <input type="text" class="form-control" name="nama_instansi" id="nama_instansi" placeholder="Masukan instansi">
                                </div>
                                <div class="form-group">
                                    <label for="posisi_bidang">Jabatan</label>
                                    <input type="text" class="form-control" name="posisi_bidang" id="posisi_bidang" placeholder="Masukan jabatan">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal keluar</label>
                                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" aria-describedby="selesaiHelp">
                                    <div id="selesaiHelp" class="form-text">Masukan jika perlu.</div>
                                </div>
                            </div>  

                            <div id="wirausahaForm" class="formKarir" style="display: none;">
                                <div class="form-group">
                                    <label for="nama_instansi">Nama Usaha</label>
                                    <input type="text" class="form-control" name="nama_instansi" id="nama_instansi" placeholder="Masukan instansi">
                                </div>
                                <div class="form-group">
                                    <label for="posisi_bidang">Bidang</label>
                                    <input type="text" class="form-control" name="posisi_bidang" id="posisi_bidang" placeholder="Masukan bidang">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Berhenti</label>
                                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai" aria-describedby="selesaiHelp">
                                    <div id="selesaiHelp" class="form-text">Masukan jika perlu.</div>
                                </div>
                            </div>  
    
                        </div>       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="button" class="btn btn-success" onclick="submitForm()">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Show/hide form sections based on the selected career type
            document.getElementById('jenis_karir').addEventListener('change', function () {
                var selectedCareer = this.value;

                // Hide all forms
                document.querySelectorAll('.formKarir').forEach(function (form) {
                    form.style.display = 'none';
                });

                // Show the form based on the selected career type
                document.getElementById(selectedCareer + 'Form').style.display = 'block';
            });
        });

        function submitForm() {
            // Retrieve form data based on the selected career type
            var selectedCareer = $('#jenis_karir').val();
            var formData = {
                jenis_karir: selectedCareer,
                nama_instansi: $('#nama_instansi').val(),
                posisi_bidang: $('#posisi_bidang').val(),
                tanggal_mulai: $('#tanggal_mulai').val(),
                tanggal_selesai: $('#tanggal_selesai').val()
            };

            // Log the form data for testing
            console.log(formData);

            // Do something with the form data, for example, send it to the server via AJAX
            try {
                $.ajax({
                    type: 'POST',
                    url: '/profile/add-karir',
                    data: {
                        jenis_karir: formData.jenis_karir,
                        nama_instansi: formData.nama_instansi,
                        posisi_bidang: formData.posisi_bidang,
                        tanggal_mulai: formData.tanggal_mulai,
                        tanggal_selesai: formData.tanggal_selesai,
                        _token: "{{ csrf_token() }}"
                    }
                });
            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
            }
        }

        function kembali() {
            window.history.back();
        }
    </script>
@endsection
