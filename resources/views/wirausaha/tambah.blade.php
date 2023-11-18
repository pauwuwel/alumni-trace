@extends('layout.index')
@section('title', 'Tambah Karir Wirausaha')
@section('page', 'Karir Wirausaha')
@section('Karir Wirausaha', 'active')
@section('content')
    <div class="card">
        <div class="card-header">
            Tambah Karir Wirausaha
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group d-flex flex-column" style="gap: 10px">

                    <input type="text" class="form-control" name="bidang" placeholder="isi bidang">
                    <textarea class="form-control" name="alamat" rows="2" placeholder="isi alamat"></textarea>

                    <label for="">Tanggal masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk">

                    <label for="">Tanggal berhenti</label>
                    <input type="date" class="form-control" name="tanggal_berhenti">

                    <input type="hidden" class="form-control" name="id_alumni" value="{{ $data->id_alumni }}">
                    @csrf

                </div>
                <div class="d-flex mt-2" style="gap: 6px;text-decoration: none">
                    <button type="submit" class="btn btn-success">Tambah Wirausaha</button>
                    <a href="/wirausaha">
                        <button type="button" class="btn btn-secondary">Kembali</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
