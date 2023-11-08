@extends('layout.index')
@section('title','komentar')
@section('page','komentar')
@section('content')
    <div class="card">
        <div class="card-header">
            Tambah Komentar
        </div>
        <div class="card-body">
            <form action="{{ url('/forum/komentar/tambah/'. $forum->id_forum)}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="komentar">Komentar</label>
                    <textarea name="komentar" class="form-control" rows="6" style="resize: none"></textarea>
                </div>
                <div class="form-group">
                    <label for="attachment">Attachment</label>
                    <input type="file" name="attachment" id="attachment" class="form-control">
                </div>
                <input type="hidden" name="id_forum" id="" class="form-control" value="{{$forum->id_forum}}">
                @csrf
                <div class="d-flex mt-2" style="gap: 6px; text-direction:row">
                    <button class="btn btn-success" type="submit">Tambah Komen</button>
                    <a href="/forum">
                        <button class="btn btn-secondary">Kembali</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection