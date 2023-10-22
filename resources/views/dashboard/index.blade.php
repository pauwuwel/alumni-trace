@extends('layout.index')
@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('page', 'dashboard')
@section('content')
    <div class="row">
        <div class="col-md-7">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Konfirmasi Forum</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr>
                            <td class="d-flex">
                                <p class="fw-bold">{{ $data->nama }}</p>
                                <p>,&nbsp;</p>
                                <p>{{ $data->judul }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection