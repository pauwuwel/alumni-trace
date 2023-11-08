@extends('layout.index')
@section('title', 'komentar')
@section('page', 'komentar')
@section('content')
    <div class="card">
        <div class="card-header">
            Edit Komentar
        </div>
        <div class="card-body">
            <form action="{{ url('/forum/komentar/update/' . $data->id_komentar) }}" method="post"
                enctype="multipart/form-data">
                <div class="form-group">
                    <label for="komentar">Komentar</label>
                    <textarea name="komentar" class="form-control" rows="6" style="resize: none">{{ $data->komentar }}</textarea>
                </div>
                <div class="form-group">
                    <label for="attachment">Attachment</label>
                    <input type="file" name="attachment" id="attachment" class="form-control">
                </div>
                <input type="hidden" name="id_komentar" value="{{ $data->id_komentar }}">
                @csrf
                <div class="d-flex mt-2" style="gap: 6px; text-direction:row">
                    <button class="btn btn-success" type="submit">Edit Komen</button>
                    <a href="forum">
                        <button class="btn btn-secondary">Kembali</button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection