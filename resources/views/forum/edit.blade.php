@extends('layout.index')
@section('title', 'Tambah Forum')
@section('forum', 'active')
@section('page', 'Forum')
@section('content')
<div class="card">
        <div class="card-header">
            Edit Forum
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group d-flex flex-column" style="gap: 10px">
                    <input type="text" class="form-control" name="judul" placeholder="Judul Forum" value="{{ $data->judul }}">
                    <textarea class="form-control" name="content" rows="6" placeholder="Isi Forum">{{ $data->content }}</textarea>
                    <input type="file" name="attachment" class="form-control">
                    <input type="hidden" name="id_forum" class="form-control" value="{{ $data->id_forum }}">
                    @csrf
                </div>
                <div class="d-flex mt-2" style="gap: 6px;text-decoration: none">
                    <button type="submit" class="btn btn-primary">Edit Forum</button>
                    <a href="/forum">
                        <button type="button" class="btn btn-secondary">Kembali</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
