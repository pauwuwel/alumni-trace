@extends('layout.index')
@section('title', 'Tambah Karir kerja')
@section('page', 'Karir kerja')
@section('Karir kerja', 'active')
@section('content')
    <div class="card">
        <div class="card-header">
            Tambah Karir kerja
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group d-flex flex-column" style="gap: 10px">

                    <input type="text" class="form-control" name="instansi" placeholder="isi instansi"
                        value="{{ $data->instansi }}">
                    <input type="text" class="form-control" name="jabatan" placeholder="isi jabatan"
                        value="{{ $data->jabatan }}">

                    <label for="">Tanggal masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk" value="{{ $data->tanggal_masuk }}">

                    <label for="">Tanggal keluar</label>
                    <input type="date" class="form-control" name="tanggal_keluar" value="{{ $data->tanggal_keluar }}">

                    <input type="hidden" class="form-control" name="id_kerja" value="{{ $data->id_kerja }}">
                    @csrf

                </div>
                <div class="d-flex mt-2" style="gap: 6px;text-decoration: none">
                    <button type="submit" class="btn btn-success">Edit kerja</button>
                    <a href="/kerja">
                        <button type="button" class="btn btn-secondary">Kembali</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
