@extends('layout.index')
@section('title', 'Forum')
@section('logs', 'active')
@section('page', 'Log Activity')
@section('content')
<div class="container-fluid d-flex flex-column mb-5" style="gap:20px">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Tabel</th>
                <th scope="col">Nama</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Jam</th>
                <th scope="col">Aksi</th>
                <th scope="col">Record</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $log->tabel }}</td>
                    <td>{{ $log->nama }}</td>
                    <td>{{ $log->tanggal }}</td>
                    <td>{{ $log->jam }}</td>
                    <td>{{ $log->aksi }}</td>
                    <td>{{ $log->record }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection