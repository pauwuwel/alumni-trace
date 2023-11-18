@extends('layout.index')
@section('title', 'Karir Kerja')
@section('page', 'Karir Kerja')
@section('content')
    <div class="d-flex justify-content-end">
        <a href="/kerja/tambah">
            <button class="btn btn-success mb-2">Tambah Karir</button>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Instansi</th>
                    <th>Jabatan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Berhenti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kerja as $item)
                    <tr>
                        <td>{{ $item->instansi }}</td>
                        <td>{{ $item->jabatan }}</td>
                        <td>{{ $item->tanggal_masuk }}</td>
                        <td>{{ $item->tanggal_keluar }}</td>
                        <td>
                            <button class="btn btn-danger btnHapus" idKerja="{{ $item->id_kerja }}">Hapus</button>
                            <a href="/kerja/edit/{{ $item->id_kerja }}">
                                <button class="btn btn-info text-white">Edit</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script type="module">
        $('div').on('click', '.btnHapus', function(a) {
            a.preventDefault();
            let idKerja = $(this).closest('.btnHapus').attr('idKerja');
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
                        url: '/kerja/hapus',
                        data: {
                            id_kerja: idKerja,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    window.location.href = '/kerja';
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
