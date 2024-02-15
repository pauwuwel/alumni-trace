@extends('layout.index')
@section('title', 'Riwayat Aktivitas')
@section('page', 'Riwayat Aktivitas')
@section('content')
    <ul class="list-group">

        @forelse ($logsData as $logs)
            <li class="btn rounded-0 list-group-item list-group-item-action list-group-item-{{ $logs->action == 'INSERT' ? 'success' : ( $logs->action == 'UPDATE' ? 'warning' : ( $logs->action == 'DELETE' || $logs->action == 'REJECT' ? 'danger' : (  $logs->action == 'ACCEPT' ? 'info' : '' ) ) ) }}">
                {{ $logs->actor == auth()->user()->username ? 'Anda ' : $logs->actor }}
                {{ $logs->action == 'INSERT' ? 'membuat ' : ( $logs->action == 'UPDATE' ? 'mengedit ' : ( $logs->action == 'DELETE' ? 'menghapus ' : (  $logs->action == 'ACCEPT' ? 'mengkonfirmasi ' : ( $logs->action == 'REJECT' ? 'menolak ' : '' ) ) ) ) }}
                {{ $logs->table }}
                {{ 'dengan id ' . $logs->row . ' || ' }}
                {{ $logs->date }}
            </li>
        @empty
            <li class="list-group-item disabled">Tidak ada riwayat aktivitas</li>
        @endforelse

    </ul>
@endsection