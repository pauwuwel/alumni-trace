@extends('layout.index')
@section('title', 'Tambah Forum')
@section('forum', 'active')
@section('page', 'Forum')
@section('content')
    <div class="card">
        <div class="card-header">
            Tambah Forum
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group d-flex flex-column" style="gap: 10px">
                    <input type="text" class="form-control" name="judul" placeholder="Judul Forum">
                    <textarea class="form-control" name="content" rows="6" placeholder="Isi Forum"></textarea>
                    <input type="file" name="attachment" class="form-control">
                    @csrf

                </div>
                <div class="d-flex mt-2" style="gap: 6px;text-decoration: none">
                    <button type="submit" class="btn btn-success">Tambah Forum</button>
                    <a href="/forum">
                        <button type="button" class="btn btn-secondary">Kembali</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
