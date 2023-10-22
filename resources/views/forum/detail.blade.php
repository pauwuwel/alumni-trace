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
            <div class="d-flex justify-content-end" style="gap:10px">
                <button class="btn btn-danger text-white btnHapus" idForum="{{ $data->id_forum }}">Hapus</button>
                <a href="/forum/edit/{{$data->id_forum}}" style="text-decoration:none">
                    <button class="btn btn-primary">Edit</button>
                </a>
                <a href="/forum" style="text-decoration:none">
                    <button class="btn btn-secondary">Kembali</button>
                </a>
            </div>
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
    </script>
@endsection
