@extends('layout.index')
@section('title', 'Kelola Akun')
@section('account', 'active')
@section('page', 'Kelola Akun')
@section('content')
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
    </head>
    <body>
        <div class="d-flex justify-content-end">
            <a href="kelola-akun/tambah">
                <button class="btn btn-success mb-2">Tambah Akun</button>
            </a>
        </div>
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
                @foreach ( $datas as $data )
                    <tr>
                        <td>{{ $data->username }}</td>
                        <td>{{ $data->password }}</td>
                        <td>{{ $data->role }}</td>
                        <td style="width: 12%">
                            <button class="btn btn-danger text-white">Hapus</button>
                            <button class="btn btn-info text-white">Edit</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
    </html>
@endsection