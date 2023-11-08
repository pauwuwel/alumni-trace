@extends('layout.index')
@section('title', 'Forum')
@section('forum', 'active')
@section('page', 'Forum')
@section('content')
    <div class="container-fluid">
        @foreach ($datas as $data)
            <div class="d-flex align-items-end" style="gap: 12px">
                <h2 class="fw-bolder">{{ $data->judul }}</h2>
                <h5>{{ $data->nama }} || {{ $data->tanggal_post }}</h5>
            </div>
            <div class="content">
                <p>{{ $data->content }}</p>
            </div>

            <div>
                    <img src="{{url('img/'. '/' . $data->attachment)}}"
                        style="max-width: 250px; height: auto;" />
            </div>

            <div class="d-flex justify-content-end" style="gap:10px">
                <button class="btn btn-danger text-white btnHapus" idForum="{{ $data->id_forum }}">Hapus</button>
                <a href="/forum/edit/{{$data->id_forum}}" style="text-decoration:none">
                    <button class="btn btn-primary">Edit</button>
                </a>
                <a href="/forum" style="text-decoration:none">
                    <button class="btn btn-secondary">Kembali</button>
                </a>
                <a href="/forum/komentar/{{ $data->id_forum }}" style="text-decoration: none">
                    <button class="btn btn-success">Komentar</button>
                </a>
            </div>
        @endforeach
        @foreach ($komentar as $komen)
            @if ($data->id_forum == $komen->id_forum)
                <div class="card-top border-top border-3 mt-3 mb-5">
                    <div style="margin-top: 20px">
                        <h5 class="fs-6 fw-bold">
                            <h6>{{ $komen->username }} || {{ $komen->tanggal_post }}</h6>
                            <h6>{{ $komen->komentar }}</h6>
                        </h5>
                    </div>
                    @if ($komen->attachment)
                        <div>
                            <img src="{{ url('attachment_komentar' . '/' . $komen->attachment) }}"
                                style="max-width: 250px; height: auto;" width="auto" />
                        </div>
                    @endif
                    <div style="float: right; margin-bottom: 60px">
                        <a href="/forum/komentar/edit/{{ $komen->id_komentar }}" style="text-decoration: none">
                            <span class="text-primary">Edit</span>
                        </a>
                        <span class="text-danger btnKomentar" style="cursor: pointer"
                            idKomen="{{ $komen->id_komentar }}">Hapus</span>

                    </div>
                </div>
            @endif
        @endforeach
    </div>
    <script type="module">
        $('div').on('click', '.btnHapus', function(a) {
            a.preventDefault();
            let idForum = $(this).closest('.btnHapus').attr('idForum');
            swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#969696',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    //Ajax Delete
                    $.ajax({
                        type: 'DELETE',
                        url: '/forum/hapus',
                        data: {
                            id_forum: idForum,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    window.location.href = '/forum';
                                });
                            }
                        }
                    });
                }
            });
        });

        $('div').on('click', '.btnKomentar', function(event) {
            event.preventDefault();
            let idKomen = $(this).attr('idKomen');

            swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#969696',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Ajax Delete
                    $.ajax({
                        type: 'DELETE',
                        url: '/forum/komentar/hapus',
                        data: {
                            id_komentar: idKomen,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    // Refresh Halaman
                                    window.location.href = '/forum';
                                });
                            }
                        }
                    });
                }
            });
    });
    </script>
@endsection
