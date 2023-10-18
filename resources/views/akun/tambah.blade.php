@extends('layout.index')
@section('title', 'Kelola Akun')
@section('account', 'active')
@section('page', 'Kelola Akun')
@section('content')
    <div class="card">
        <div class="card-header">
            Tambah Akun
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Masukan username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" name="password" id="password"
                        placeholder="Masukan password">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-select" name="role" id="role">
                        <option selected hidden disabled>Pilih Role</option>
                        <option value="admin">Admin</option>
                        <option value="alumni">Alumni</option>
                    </select>
                    @csrf
                </div>
                <div class="d-flex mt-2" style="gap: 6px;text-decoration: none">
                    <button type="submit" class="btn btn-success">Tambah Akun</button>
                    <a href="/kelola-akun">
                        <btn class="btn btn-secondary">Kembali</btn>
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
