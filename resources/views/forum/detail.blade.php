@extends('layout.index')
@section('title', 'Forum')
@section('forum', 'active')
@section('page', 'Forum')
@section('style')
    <style>
        .hr-container {
            display: flex;
            align-items: center;
            text-align: flex;
        }

        .hr-container hr {
            flex: 1;
            margin: 0;
        }

        .hr-container .text {
            padding: 0 10px;
            color: #888;
        }

        .kdd ul {
            min-width: 0px !important;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        @foreach ($forum_data as $data)
            <div style="float: right">
                <a target="_blank" href="/forum/print-pdf/{{ $data->id_forum }}" class="btn btn-sm btn-warning text-white"><i
                        class="bi bi-printer"></i> Print</a>
            </div>
            <div class="d-flex align-items-end" style="gap: 12px">
                <h2 class="fw-bolder">{{ $data->judul }}</h2>
                <h5>{{ $data->nama_pembuat }} || {{ $data->tanggal_post }}</h5>
            </div>
            <div class="content">
                <p class="text-break">{{ $data->content }}</p>
            </div>
            <div class="d-flex">
                @if ($data->attachment !== null)
                    <img src="{{ url('img') . '/' . $data->attachment }}" alt="attachment" style="max-width: 34vw">
                @endif
            </div>


            @if ($data->status !== 'pending')
                <div class="d-flex flex-column mb-2">
                    <div class="hr-container">
                        <span class="text-muted text">{{ $data->totalKomentar }} Komentar</span>
                        <hr class="my-4">
                    </div>

                    <div class="d-flex flex-column mb-4" style="gap: 11px">

                        @foreach ($data->komentar as $komen)
                            <div class="row">
                                <div class="col-12 d-flex">
                                    <div class="fw-bold">{{ $komen->nama_pembuat }}&nbsp;</div>
                                    <div>|| {{ $komen->tanggal_post }}&nbsp;</div>
                                    @if (auth()->user()->id_akun == $komen->id_pembuat || auth()->user()->role == 'admin')
                                        <div class="dropdown kdd">
                                            <i class="bi bi-three-dots-vertical" style="cursor: pointer;"
                                                class="dropdown-toggle"id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-expanded="false"></i>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <li><a class="dropdown-item btn btnHapusKomen"
                                                        idForum="{{ $data->id_forum }}" idKomen="{{ $komen->id_komentar }}"
                                                        href="#"><i class="bi bi-trash-fill text-danger"></i></a></li>
                                                <li><a class="dropdown-item btn btnEditKomen"
                                                        idForum="{{ $data->id_forum }}"
                                                        idKomen="{{ $komen->id_komentar }}" href="#"><i
                                                            class="bi bi-pencil-square text-primary"></i></a></li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12">
                                    {{ $komen->komentar }}
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <form method="POST" action="/forum/add-komentar" class="d-flex">
                        <input type="text" id="komentar" name="komentar" class="form-control"
                            placeholder="Tuliskan komentar...">
                        <input type="hidden" id="id_forum" name="id_forum" class="form-control"
                            value="{{ $data->id_forum }}">
                        <input type="hidden" id="id_pembuat" name="id_pembuat" class="form-control"
                            value="{{ auth()->user()->id_akun }}">
                        @csrf
                        <button id="send-button" class="btn btn-primary ms-2"
                            onclick="addKomen({{ $data->id_forum }}, event)">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>

                </div>
            @endif

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
                    @if ($data->id_pembuat == auth()->user()->id_akun || auth()->user()->role == "admin")
                        <button class="btn btn-danger text-white btnHapus" idForum="{{ $data->id_forum }}">Hapus</button>
                        <a href="/forum/edit/{{ $data->id_forum }}" style="text-decoration:none">
                            <button class="btn btn-primary">Edit</button>
                        </a>
                    @endif
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
                        url: '/forum/status',
                        data: {
                            id_forum: idForum,
                            id_admin: "{{ auth()->user()->id_akun }}",
                            status: 'accepted',
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Forum di Konfirmasi!', '', 'success').then(
                                    function() {
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
                text: "Forum yang ditolak akan dimasukan ke arsip!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#969696',
                confirmButtonText: 'Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/forum/status',
                        data: {
                            id_forum: idForum,
                            id_admin: "{{ auth()->user()->id_akun }}",
                            status: "rejected",
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di tolak!', '', 'success').then(function() {
                                    window.location.href = '/dashboard';
                                });
                            }
                        }
                    });
                }
            });
        });

        $('div').on('click', '.btnHapus', function(a) {
            a.preventDefault();
            let idForum = $(this).closest('.btnHapus').attr('idForum');

            swal.fire({
                title: 'Apakah anda yakin?',
                text: "Forum yang dihapus akan dimasukan ke arsip!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff0000',
                cancelButtonColor: '#969696',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '/forum/hapus',
                        data: {
                            id_forum: idForum,
                            id_actor: "{{ auth()->user()->id_akun }}",
                            status: 'deleted',
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di tolak!', '', 'success').then(function() {
                                    window.location.href = '/forum';
                                });
                            }
                        }
                    });
                }
            });
        });

        $('ul').on('click', '.btnHapusKomen', function(a) {
            a.preventDefault();
            let idForum = $(this).closest('.btnHapusKomen').attr('idForum');
            let idKomen = $(this).closest('.btnHapusKomen').attr('idKomen');

            swal.fire({
                title: 'Apakah anda yakin?',
                text: "Komentar yang dihapus tidak bisa dikembalikan!",
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
                        url: '/forum/hapus-komen',
                        data: {
                            id_komentar: idKomen,
                            id_user: "{{ auth()->user()->id_akun }}",
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    window.location.href = '/forum/post/' + idForum;
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
