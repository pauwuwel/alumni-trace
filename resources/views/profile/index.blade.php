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
                            <textarea name="alamat" class="form-control" style="resize: none" disabled id="alamat" rows="5">{{ $data->jalan !== null ? 'Jalan ' . $data->jalan : '' }} {{ $data->gang !== null ? 'Gang ' . $data->gang : '' }} {{ $data->nomor_rumah !== null ? 'No. ' . $data->nomor_rumah : '' }} {{ $data->blok !== null ? 'Blok ' . $data->blok : '' }} {{ $data->rt !== null ? 'RT ' . $data->rt : '' }} {{ $data->rw !== null ? 'RW ' . $data->rw : '' }} {{ $data->kelurahan !== null ? 'Kelurahan ' . $data->kelurahan : '' }} {{ $data->kecamatan !== null ? 'Kecamatan ' . $data->kecamatan : '' }} {{ $data->kota !== null ? 'Kota ' . $data->kota : '' }} {{ $data->kodepos !== null ? $data->kodepos : '' }} </textarea>
                        </div>
                    @endif
                    @if ($data->role == 'alumni')
                        <div class="hr-container">
                            <hr class="my-4">
                            <span class="text-muted text">Riwayat Karir</span>
                            <hr class="my-4">
                        </div>
                        <div class="form-group">
                            <table class="table table-hover">
                                <thead>
                                    @if ($data->id_akun == auth()->user()->id_akun)
                                        <tr>
                                            <td colspan="2">
                                                <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal">Tambah Karir</button>
                                            </td>
                                        </tr>
                                    @endif
                                </thead>
                                <tbody>
                                    @forelse ($career as $karir)
                                        <tr>
                                            <td>
                                                {{ $karir->tanggal_selesai !== null ? 'Telah ' : 'Sedang ' }}
                                                {{ $karir->jenis_karir == 'kuliah'
                                                    ? 'menjalankan kuliah di '
                                                    : ($karir->jenis_karir == 'kerja'
                                                        ? 'bekerja pada '
                                                        : ($karir->jenis_karir == 'wirausaha'
                                                            ? 'menjalankan usaha dengan nama '
                                                            : '')) }}
                                                {{ $karir->nama_instansi }}
                                                {{ $karir->jenis_karir == 'kuliah'
                                                    ? 'dengan jurusan '
                                                    : ($karir->jenis_karir == 'kerja'
                                                        ? 'dengan jabatan '
                                                        : ($karir->jenis_karir == 'wirausaha'
                                                            ? 'dalam bidang '
                                                            : '')) }}
                                                {{ $karir->posisi_bidang }}
                                                {{ $karir->tanggal_selesai !== null ? 'pada ' : 'sejak ' }}
                                                {{ $karir->tanggal_mulai_iso }}
                                                {{ $karir->tanggal_selesai !== null ? 'hingga ' . $karir->tanggal_selesai_iso : ' ' }}
                                            </td>
                                            @if ($data->id_akun == auth()->user()->id_akun)
                                                <td style="width: 10%">
                                                    <div class="d-flex" style="gap:5px;">
                                                        <button class="btn btn-sm btn-info text-white btnHapus" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $karir->id_karir }}">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </button>

                                                        <button class="btn btn-sm btn-danger text-white btnHapus"
                                                            onclick="hapusKarir({{ $karir->id_karir }}, event)"><i
                                                                class="bi bi-trash-fill"></i></button>
                                                    </div>
                                                </td>

                                                <div class="modal fade" id="editModal{{ $karir->id_karir }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Karir</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST" action="edit-karir/{{ auth()->user()->id_akun }}">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="d-flex flex-column">
                                                                        <div class="form-group">
                                                                            <label for="edit_jenis_karir">Jenjang Karir</label>
                                                                            <select required class="form-control" name="edit_jenis_karir" id="edit_jenis_karir" disabled>
                                                                                <option {{ $karir->jenis_karir == 'kuliah' ? 'selected' : '' }} value="kuliah">Kuliah</option>
                                                                                <option {{ $karir->jenis_karir == 'kerja' ? 'selected' : '' }} value="kerja">Kerja</option>
                                                                                <option {{ $karir->jenis_karir == 'wirausaha' ? 'selected' : '' }} value="wirausaha">Wirausaha</option>
                                                                            </select>
                                                                            <input type="hidden" name="jenis_karir" value="{{ $karir->jenis_karir }}">
                                                                            <input type="hidden" name="id_alumni" value="{{ $karir->id_alumni }}">
                                                                            <input type="hidden" name="id_karir" value="{{ $karir->id_karir }}">
                                                                        </div>

                                                                        <div id="editKarirForm" class="formEditKarir">
                                                                            <div class="form-group">
                                                                                <label for="nama_instansi">{{ $karir->jenis_karir == 'kuliah' || $karir->jenis_karir == 'kerja' ? 'Instansi' : 'Nama Usaha' }}</label>
                                                                                <input type="text" class="form-control" name="nama_instansi"
                                                                                    id="nama_instansi" placeholder="Masukan instansi" value="{{ $karir->nama_instansi }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="posisi_bidang">{{ $karir->jenis_karir == 'kuliah' ? 'Jurusan' : ( $karir->jenis_karir == 'kerja' ? 'Jabatan' : ( $karir->jenis_karir == 'wirausaha' ? 'Bidang' : '' ) ) }}</label>
                                                                                <input type="text" class="form-control" name="posisi_bidang"
                                                                                    id="posisi_bidang" placeholder="Masukan jurusan" value="{{ $karir->posisi_bidang }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="tanggal_mulai">Tanggal {{ $karir->jenis_karir == 'kuliah' || $karir->jenis_karir == 'kerja' ? 'Masuk' : 'Mulai' }}</label>
                                                                                <input type="date" class="form-control" name="tanggal_mulai"
                                                                                    id="tanggal_mulai" value="{{ $karir->tanggal_mulai }}">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="tanggal_selesai">Tanggal {{ $karir->jenis_karir == 'kuliah' ? 'Lulus' : ( $karir->jenis_karir == 'kerja' ? 'Keluar' : ( $karir->jenis_karir == 'wirausaha' ? 'Berhenti' : '' ) ) }}</label>
                                                                                <input type="date" class="form-control" name="tanggal_selesai"
                                                                                    id="tanggal_selesai" aria-describedby="selesaiHelp" value="{{ $karir->tanggal_selesai }}">
                                                                                <div id="selesaiHelp" class="form-text">Masukan jika perlu.</div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                                                    <button type="submit" class="btn btn-info text-white">Edit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ $data->id_akun == auth()->user()->id_akun ? '2' : '1' }}" class="text-center text-muted">
                                                Tidak memiliki riwayat karir</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif
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
                                    <input type="text" class="form-control" name="nama_instansi_kuliah"
                                        id="nama_instansi_kuliah" placeholder="Masukan instansi">
                                </div>
                                <div class="form-group">
                                    <label for="posisi_bidang">Jurusan</label>
                                    <input type="text" class="form-control" name="posisi_bidang_kuliah"
                                        id="posisi_bidang_kuliah" placeholder="Masukan jurusan">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tanggal_mulai_kuliah"
                                        id="tanggal_mulai_kuliah">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Lulus</label>
                                    <input type="date" class="form-control" name="tanggal_selesai_kuliah"
                                        id="tanggal_selesai_kuliah" aria-describedby="selesaiHelp">
                                    <div id="selesaiHelp" class="form-text">Masukan jika perlu.</div>
                                </div>
                            </div>

                            <div id="kerjaForm" class="formKarir" style="display: none;">
                                <div class="form-group">
                                    <label for="nama_instansi">Instansi</label>
                                    <input type="text" class="form-control" name="nama_instansi_kerja"
                                        id="nama_instansi_kerja" placeholder="Masukan instansi">
                                </div>
                                <div class="form-group">
                                    <label for="posisi_bidang">Jabatan</label>
                                    <input type="text" class="form-control" name="posisi_bidang_kerja"
                                        id="posisi_bidang_kerja" placeholder="Masukan jabatan">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tanggal_mulai_kerja"
                                        id="tanggal_mulai_kerja">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Keluar</label>
                                    <input type="date" class="form-control" name="tanggal_selesai_kerja"
                                        id="tanggal_selesai_kerja" aria-describedby="selesaiHelp">
                                    <div id="selesaiHelp" class="form-text">Masukan jika perlu.</div>
                                </div>
                            </div>

                            <div id="wirausahaForm" class="formKarir" style="display: none;">
                                <div class="form-group">
                                    <label for="nama_instansi">Nama Usaha</label>
                                    <input type="text" class="form-control" name="nama_instansi_wirausaha"
                                        id="nama_instansi_wirausaha" placeholder="Masukan instansi">
                                </div>
                                <div class="form-group">
                                    <label for="posisi_bidang">Bidang</label>
                                    <input type="text" class="form-control" name="posisi_bidang_wirausaha"
                                        id="posisi_bidang_wirausaha" placeholder="Masukan bidang">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai_wirausaha"
                                        id="tanggal_mulai_wirausaha">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Berhenti</label>
                                    <input type="date" class="form-control" name="tanggal_selesai_wirausaha"
                                        id="tanggal_selesai_wirausaha" aria-describedby="selesaiHelp">
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
        document.addEventListener('DOMContentLoaded', function() {
            // Show/hide form sections based on the selected career type
            document.getElementById('jenis_karir').addEventListener('change', function() {
                var selectedCareer = this.value;

                // Hide all forms
                document.querySelectorAll('.formKarir').forEach(function(form) {
                    form.style.display = 'none';
                });

                // Show the form based on the selected career type
                document.getElementById(selectedCareer + 'Form').style.display = 'block';
            });
        });

        function hapusKarir(karirId, event) {
            event.preventDefault();
            swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#969696',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    //Ajax Delete
                    $.ajax({
                        type: 'DELETE',
                        url: '',
                        data: {
                            id_karir: karirId,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        }

        function submitForm() {
            // Retrieve form data based on the selected career type
            var selectedCareer = $('#jenis_karir').val();
            var formData = {
                jenis_karir: selectedCareer,
            };

            if (selectedCareer === 'kuliah') {
                formData.nama_instansi = $('#nama_instansi_kuliah').val();
                formData.posisi_bidang = $('#posisi_bidang_kuliah').val();
                formData.tanggal_mulai = $('#tanggal_mulai_kuliah').val();
                formData.tanggal_selesai = $('#tanggal_selesai_kuliah').val();
            } else if (selectedCareer === 'kerja') {
                formData.nama_instansi = $('#nama_instansi_kerja').val();
                formData.posisi_bidang = $('#posisi_bidang_kerja').val();
                formData.tanggal_mulai = $('#tanggal_mulai_kerja').val();
                formData.tanggal_selesai = $('#tanggal_selesai_kerja').val();
            } else if (selectedCareer === 'wirausaha') {
                formData.nama_instansi = $('#nama_instansi_wirausaha').val();
                formData.posisi_bidang = $('#posisi_bidang_wirausaha').val();
                formData.tanggal_mulai = $('#tanggal_mulai_wirausaha').val();
                formData.tanggal_selesai = $('#tanggal_selesai_wirausaha').val();
            }

            // Log the form data for testing
            console.log(formData);

            // Do something with the form data, for example, send it to the server via AJAX
            try {
                $.ajax({
                    type: 'POST',
                    url: '',
                    data: {
                        jenis_karir: formData.jenis_karir,
                        nama_instansi: formData.nama_instansi,
                        posisi_bidang: formData.posisi_bidang,
                        tanggal_mulai: formData.tanggal_mulai,
                        tanggal_selesai: formData.tanggal_selesai,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Display a SweetAlert2 success message
                        swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data karir baru berhasil ditambah',
                        }).then((result) => {
                            // Reload the page after the SweetAlert2 success message
                            if (result.isConfirmed || result.isDismissed) {
                                location.reload();
                            }
                        });
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
