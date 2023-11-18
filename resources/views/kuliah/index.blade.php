@extends('layout.index')
@section('title', 'Karir Kuliah')
@section('Karir Kuliah', 'active')
@section('page', 'Karir Kuliah')
@section('content')
    <div class="d-flex justify-content-end">
        <a href="/kuliah/tambah">
            <button class="btn btn-success mb-2">Tambah Karir</button>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Instansi</th>
                    <th>Jurusan</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Lulus</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kuliah as $item)
                    <tr>
                        <td>{{ $item->instansi }}</td>
                        <td>{{ $item->jurusan }}</td>
                        <td>{{ $item->tanggal_masuk }}</td>
                        <td>{{ $item->tanggal_lulus }}</td>
                        <td>
                            <button class="btn btn-danger btnHapus" idKuliah="{{ $item->id_kuliah }}">Hapus</button>
                            <a href="/kuliah/edit/{{ $item->id_kuliah }}">
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
            let idKuliah = $(this).closest('.btnHapus').attr('idKuliah');
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
                        url: '/kuliah/hapus',
                        data: {
                            id_kuliah: idKuliah,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    window.location.href = '/kuliah';
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
