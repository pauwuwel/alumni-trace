@extends('layout.index')
@section('title', 'Karir Wirausaha')
@section('page', 'Karir Wirausaha')
@section('Karir Wirausaha', 'active')
@section('content')
    <div class="d-flex justify-content-end">
        <a href="/wirausaha/tambah">
            <button class="btn btn-success mb-2">Tambah Karir</button>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Bidang</th>
                    <th>Alamat</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Berhenti</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($wirausaha as $item)
                    <tr>
                        <td>{{ $item->bidang }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->tanggal_masuk }}</td>
                        <td>{{ $item->tanggal_berhenti }}</td>
                        <td>
                            <button class="btn btn-danger btnHapus" idWirausaha="{{ $item->id_wirausaha }}">Hapus</button>
                            <a href="/wirausaha/edit/{{ $item->id_wirausaha }}">
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
            let idWirausaha = $(this).closest('.btnHapus').attr('idWirausaha');
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
                        url: '/wirausaha/hapus',
                        data: {
                            id_wirausaha: idWirausaha,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    window.location.href = '/wirausaha';
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
