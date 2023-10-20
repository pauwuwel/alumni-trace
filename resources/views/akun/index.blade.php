@extends('layout.index')
@section('title', 'Kelola Akun')
@section('account', 'active')
@section('page', 'Kelola Akun')
@section('content')
    <div class="d-flex justify-content-end">
        <a href="/kelola-akun/tambah">
            <button class="btn btn-success mb-2">Tambah Akun</button>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Usermame</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td>{{ $data->username }}</td>
                        <td>{{ $data->password }}</td>
                        <td>
                            @if ($data->role == 'superAdmin')
                                Super Admin
                            @elseif ($data->role == 'admin')
                                Admin
                            @elseif ($data->role == 'alumni')
                                Alumni
                            @endif
                        </td>
                        <td style="width: 12%;text-decoration: none;">
                            <button class="btn btn-danger text-white btnHapus" idAkun="{{ $data->id_akun }}">Hapus</button>
                            <a href="/kelola-akun/edit/{{ $data->id_akun }}">
                                <button class="btn btn-info text-white">Edit</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script type="module">
        $('tbody').on('click', '.btnHapus', function(a) {
            a.preventDefault();
            let idAkun = $(this).closest('.btnHapus').attr('idAkun');
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
                        url: '/kelola-akun/hapus',
                        data: {
                            id_akun: idAkun,
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
        });
    </script>
@endsection
