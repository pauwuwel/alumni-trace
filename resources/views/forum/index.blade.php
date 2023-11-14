@extends('layout.index')
@section('title', 'Forum')
@section('forum', 'active')
@section('page', 'Forum')
@section('subpage', '+ tambah forum')
@section('sublink', '/forum/tambah')
@section('content')
    <style>
        .darken-on-hover: {
            transition: background-color 0.3s ease-in-out;
        }

        .darken-on-hover:hover {
            background-color: #e8e9eb;
        }
    </style>
    <div class="container-fluid d-flex flex-column mb-5" style="gap:20px">
        @foreach ($forum_data as $forum)
            <a href="/forum/{{ $forum->id_forum }}" class="text-decoration-none text-dark">
                <button class="card text-start darken-on-hover w-100">

                    <div class="card-body w-100 p-2" style="min-height: 18vh">
        
                        <h5 class="card-title fw-bolder" style="margin: 0 0 6px 1px;">{{ $forum->judul }}</h5>
                        <h6 class="card-subtitle text-muted">{{ $forum->nama_pembuat }} || {{ $forum->tanggal_post }}</h6>
            
                        <div style="border-top: 1px solid #e0e0e0; margin: 10px 0;"></div>
            
                        <p class="card-text lh-sm mb-4">{{ $forum->content }}</p>
            
                        @if (isset($forum->komentar))

                            @foreach ($forum->komentar as $komen)
                            
                                <div style="border-top: 1px solid #e0e0e0; margin: 12px 0;"></div>

                                <h6 class="card-title fw-bolder" style="margin: 0 0 4px 1px;">{{ $komen->nama_pembuat }}</h6>
                                <h6 class="card-text text-muted">{{ $komen->komentar }}</h6>
                                
                            @endforeach

                        @endif

                    </div>

                </button>
            </a>
        @endforeach
    </div>
@endsection
{{-- @foreach ($forum_data as $item)
            <div class="rounded-3 border-secondary p-3" style="background-color :#F1F1F1">  
                <div class="d-flex align-items-end" style="gap: 10px">
                    <h4 style="font-weight: bold">{{ $item->judul }}</h4>
                    <h6>{{ $item->nama_pembuat }} || {{ $item->tanggal_post }}</h6>
                </div>
                <div class="col-12 text-truncate">{{ $item->content }}</div>
                <h6 class="text-end mt-2">
                    <a style="color:#00A9AD;text-decoration: underline" href="/forum/{{ $item->id_forum }}">
                        lihat forum
                    </a>
                </h6>
            </div>
            <div>
                @if (isset($item->komentar)) 
                    @foreach($item->komentar as $komen)
                        {{ $komen->komentar }}
                    @endforeach
                @endif
            </div>
        @endforeach --}}