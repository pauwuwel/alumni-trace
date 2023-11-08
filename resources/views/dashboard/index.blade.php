@extends('layout.index')
@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('page', 'dashboard')
@section('content')
    <div class="row">
        @if (auth()->user()->role == 'superAdmin')
            <div class="col-md-4 d-flex flex-column align-items-center justify-content-center" style="height: 20vh">
                <h2>Total Alumni:</h2>
                <h1>{{ $totalAlumni }}</h1>
            </div>
            <div class="col-md-8 shadow rounded-3" style="height: 40vh; overflow-y: auto;">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>Riwayat Perubahan Akun</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->logs }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection