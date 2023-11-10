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
                <p class="text-break">{{ $data->content }}</p>
            </div>
            @if ($data->status == 'pending')
                <div class="d-flex justify-content-end" style="gap:10px">
                    <button class="btn btn-success btnAcc" idForum="{{ $data->id_forum }}">Konfirmasi</button>
                    <button class="btn btn-danger text-white btnTolak" idForum="{{ $data->id_forum }}">Tolak</button>
                    <a href="/forum" style="text-decoration:none">
                        <button class="btn btn-secondary">Kembali</button>
                    </a>
                </div>
            @else
                <div class="d-flex justify-content-end" style="gap:10px">
                    <button class="btn btn-danger text-white btnHapus" idForum="{{ $data->id_forum }}">Hapus</button>
                    <a href="/forum/edit/{{$data->id_forum}}" style="text-decoration:none">
                        <button class="btn btn-primary">Edit</button>
                    </a>
                    <a href="/forum" style="text-decoration:none">
                        <button class="btn btn-secondary">Kembali</button>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
    <script type="module">
        $('div').on('click', '.btnAcc', function(a) {
            a.preventDefault();
            let idForum = $(this).closest('.btnAcc').attr('idForum');
            swal.fire({
                title: 'Apakah anda yakin?',
                text: "Forum ini akan dapat diakses oleh Alumni",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#969696',
                confirmButtonText: 'Konfirmasi',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    //Ajax Delete
                    $.ajax({
                        type: 'POST',
                        url: '/forum/' . idForum,
                        data: {
                            id_forum: idForum,
                            status: 'accepted',
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Forum di Konfirmasi!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    window.location.href = '/forum';
                                });
                            }
                        }
                    });
                }
            });
        });

        $('div').on('click', '.btnTolak', function(a) {
            a.preventDefault();
            let idForum = $(this).closest('.btnTolak').attr('idForum');
            swal.fire({
                title: 'Apakah anda yakin?',
                text: "Forum yang ditolak akan dihapus!",
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
                                    window.location.href = '/dashboard';
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
