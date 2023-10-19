@extends('layout.index')
@section('title', 'Kelola Akun')
@section('account', 'active')
@section('page', 'Kelola Akun')
@section('content')
    <div class="card">
        <div class="card-header">
            Edit Akun
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Masukan username" value="{{ $data->username }}">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" name="password" id="password"placeholder="Masukan password" disabled value="{{ $data->password }}">
                    <input type="hidden" name="password" value="{{ $data->password }}">
                    <input type="hidden" name="role" value="{{ $data->role }}">
                    <input type="hidden" name="id_akun" value="{{ $data->id_akun }}">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-select" name="role" id="role" {{ $data->role == 'superAdmin' ? 'disabled' : '' }}>
                        @if ($data->role == 'superAdmin')
                            <option selected value="superAdmin">Super Admin</option>
                        @endif
                        <option {{ $data->role == 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                        <option {{ $data->role == 'alumni' ? 'selected' : '' }} value="alumni">Alumni</option>
                    </select>
                    @csrf
                </div>
                <div class="d-flex mt-2" style="gap: 6px;text-decoration: none">
                    <button type="submit" class="btn btn-success">Edit Akun</button>
                    <a href="/kelola-akun">
                        <btn class="btn btn-secondary">Kembali</btn>
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
