@extends('layout.index')
@section('title', 'Forum')
@section('forum', 'active')
@section('page', 'Forum')
@section('subpage', '+ tambah forum')
@section('sublink', '/forum/tambah')
@section('style')
    <style>
        .darken-on-hover: {
            transition: background-color 0.3s ease-in-out;
        }

        .darken-on-hover:hover {
            background-color: #e8e9eb;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid d-flex flex-column mb-5" style="gap:20px">
        <div class="search-container">
            <input type="search" id="search" name="search" class="form-control" style="width:400px" placeholder="Cari judul forum...">
        </div>
        <div id="forums" class="d-flex flex-column mb-5" style="gap:20px">
            @foreach ($forum_data as $forum)
                <a href="/forum/post/{{ $forum->id_forum }}" class="text-decoration-none text-dark">
                    <button class="card text-start darken-on-hover w-100">

                        <div class="card-body w-100 p-2" style="min-height: 18vh">

                            <h5 class="card-title fw-bolder" style="margin: 0 0 6px 1px;">{{ $forum->judul }}</h5>
                            <h6 class="card-subtitle text-muted">{{ $forum->nama_pembuat }} || {{ $forum->tanggal_post }}</h6>

                            <div style="border-top: 1px solid #e0e0e0; margin: 10px 0;"></div>

                            <p class="card-text lh-sm mb-4">{{ $forum->content }}</p>

                            @if (isset($forum->komentar))
                                @foreach ($forum->komentar as $komen)
                                    <div style="border-top: 1px solid #e0e0e0; margin: 12px 0;"></div>

                                    <h6 class="card-title fw-bolder" style="margin: 0 0 4px 1px;">{{ $komen->nama_pembuat }}
                                    </h6>
                                    <h6 class="card-text text-muted">{{ $komen->komentar }}</h6>
                                @endforeach
                            @endif

                        </div>

                    </button>
                </a>
            @endforeach
        </div>
    </div>

    <script type="module">
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var searchVal = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: 'forum/search-forum',
                    data: {
                        'search': searchVal
                    },
                    success: function(data) {
                        $('#forums').html(data);
                    }
                });

            });
        });
    </script>
@endsection
