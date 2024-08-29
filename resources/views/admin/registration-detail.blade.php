@extends('layouts.app')

@section('active_registration', 'active-page')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="mb-3">Data Pendaftar - {{ $event->title }}</h3>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Tempat Tanggal Lahir</th>
                                <th>Motivasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registration as $reg)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $reg->name }}</td>
                                    <td>{{ $reg->nim }}</td>
                                    <td>{{ $reg->tempat_tanggal_lahir }}</td>
                                    <td>{{ $reg->motivasi }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection