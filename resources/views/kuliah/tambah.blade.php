@extends('layout.index')
@section('title', 'Tambah Karir kuliah')
@section('page', 'Karir kuliah')
@section('Karir kuliah', 'active')
@section('content')
    <div class="card">
        <div class="card-header">
            Tambah Karir kuliah
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group d-flex flex-column" style="gap: 10px">

                    <input type="text" class="form-control" name="instansi" placeholder="isi instansi">
                    <input type="text" class="form-control" name="jurusan" placeholder="isi jurusan">

                    <label for="">Tanggal masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk">

                    <label for="">Tanggal lulus</label>
                    <input type="date" class="form-control" name="tanggal_lulus">

                    <input type="hidden" class="form-control" name="id_alumni" value="{{ $data->id_alumni }}">
                    @csrf

                </div>
                <div class="d-flex mt-2" style="gap: 6px;text-decoration: none">
                    <button type="submit" class="btn btn-success">Tambah kuliah</button>
                    <a href="/kuliah">
                        <button type="button" class="btn btn-secondary">Kembali</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
