@extends('layout.index')
@section('title', 'Log Activity')
@section('gallery', 'active')
@section('page', 'Log Activity')
@section('content')
    <div class="row container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>Riwayat Perubahan Karir</td>
                    <td style="width:20%">
                    </td>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 0;
                @endphp

                @for ($i = 0; $i < count($logs); $i++)
                    @if (strpos($logs[$i]->logs, 'superadmin') === false)
                        <tr>
                            <td>{{ $logs[$i]->logs }}</td>
                        </tr>
                    @endif
                @endfor
            </tbody>
        </table>
    </div>
@endsection