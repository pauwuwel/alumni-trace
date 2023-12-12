@extends('layout.index')
@section('title', 'Galeri')
@section('gallery', 'active')
@section('page', 'Galeri')
@section('content')
    <div class="row">
        <div class="form-group">
            <label for="search">Cari Alumni</label>
            <input type="search" name="search" id="search" placeholder="Masukan nama alumni..." class="form-control mb-4" style="width: 400px;">
        </div>
        <div id="galeri" class="row">
            @foreach ($datas as $data)
                <div class="col-md-2 col-sm-12 mb-2">
                    <a style="text-decoration:none;" href="/profile/{{ $data->id_akun }}">
                        <button class="card w-100 rounded-3 d-flex flex-column justify-content-between p-3 h-100">
                            <img src="{{ $data->foto !== null ? url('img/' . $data->foto) : url('img/pp.png') }}" alt="pp"
                                class="w-100 mb-2 rounded" srcset="">
                            <h4 class="text-capitalize text-bold w-100">{{ $data->nama }}</h4>
                        </button>
                    </a>
                </div>
            @endforeach
        </div>
    </div>


    <script type="module">
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                var searchVal = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: 'galeri/search-alumni',
                    data: {
                        'search': searchVal
                    },
                    success: function(data) {
                        $('#galeri').html(data);
                    }
                });

            });
        });
    </script>
@endsection
