@extends('layout.index')
@section('title', 'Kelola Akun')
@section('account', 'active')
@section('page', 'Kelola Akun')
@section('content')
    <div class="d-flex justify-content-end">
        <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Akun</button>
        {{-- <a href="/kelola-akun/tambah">
            <button class="btn btn-success mb-2">Tambah Akun</button>
        </a> --}}
    </div>
    <div class="">
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
                        <td style="text-decoration: none;">
                            <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $data->id_akun }}">
                                <i class="bi bi-pencil-fill"></i>
                            </button>

                            <button
                                class="btn btn-sm btn-danger text-white btnHapus {{ $data->role === 'superAdmin' ? 'disabled' : '' }} "
                                idAkun="{{ $data->id_akun }}""><i class="bi bi-trash-fill"></i></button>

                            <div class="modal fade" id="editModal{{ $data->id_akun }}" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Karir</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form id="editForm{{ $data->id_akun }}" data-id="{{ $data->id_akun }}">
                                            <div class="modal-body">
                                                <div class="d-flex flex-column" style="gap: 10px">
                                                    <div class="form-group">
                                                        <label for="username">Username</label>
                                                        <input type="text" class="form-control" name="username"
                                                            id="username" placeholder="Masukan Username"
                                                            value="{{ $data->username }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <input type="text" class="form-control" name="password"
                                                            id="password" placeholder="Masukan password"
                                                            value="{{ $data->password }}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="role">Pilih Role</label>
                                                        <select required class="form-control" name="role" id="role"
                                                            disabled>
                                                            <option {{ $data->role == 'admin' ? 'selected' : '' }}
                                                                value="admin">Admin</option>
                                                            <option {{ $data->role == 'alumni' ? 'selected' : '' }}
                                                                value="alumni">Alumni
                                                            </option>
                                                            <option {{ $data->role == 'superAdmin' ? 'selected' : '' }}
                                                                value="superAdmin">
                                                                Super Admin
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @csrf
                                                <input type="hidden" name="id_akun" value="{{ $data->id_akun }}">
                                                <input type="hidden" name="role" value="{{ $data->role }}">
                                                <input type="hidden" name="old_username" value="{{ $data->username }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Kembali</button>
                                                <button type="button" class="btn btn-info text-white"
                                                    onclick="submitEditForm({{ $data->id_akun }})">
                                                    Edit
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Akun</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <div class="d-flex flex-column" style="gap: 10px">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                    placeholder="Masukan Username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="text" class="form-control" name="password" id="password"
                                    placeholder="Masukan password">
                            </div>
                            <div class="form-group">
                                <label for="role">Pilih Role</label>
                                <select required class="form-control" name="role" id="role">
                                    <option selected value="" hidden>Pilih Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="alumni">Alumni</option>
                                </select>
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
        function submitForm() {
            // Retrieve form data
            var username = $('#username').val();
            var password = $('#password').val();
            var role = $('#role').val();

            // Construct the form data object
            var formData = {
                username: username,
                password: password,
                role: role,
                _token: "{{ csrf_token() }}" // Include CSRF token
            };

            // Send the form data to the server via AJAX
            $.ajax({
                type: 'POST',
                url: '/kelola-akun/tambah',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Display success message
                        swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.success,
                        }).then((result) => {
                            // Reload the page after the success message
                            if (result.isConfirmed || result.isDismissed) {
                                location.reload();
                            }
                        });
                    } else if (response.error) {
                        // Display specific error message for duplicate username
                        swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: response.error,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Display network error message
                    swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menambah akun. Silakan coba lagi.',
                    });
                    console.error('Error:', error);
                }
            });
        }

        function submitEditForm(id) {
            var form = $('#editForm' + id);
            var formData = form.serialize();

            $.ajax({
                type: 'POST',
                url: '/kelola-akun/edit/' + id,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Display success message
                        swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.success,
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                location.reload();
                            }
                        });
                    } else if (response.error) {
                        // Display error message
                        swal.fire({
                            icon: 'warning',
                            title: 'Perhatian!',
                            text: response.error,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Display network error message
                    swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat mengedit akun. Silakan coba lagi.',
                    });
                    console.error('Error:', error);
                }
            });
        }
    </script>

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
