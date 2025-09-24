@extends('layouts.hris')

@section('title', 'Dokumen Karyawan')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Dokumen & Sertifikat</h1>
        </div>
        <div class="col-sm-6">
            <div class="float-right">
                <a href="{{ route('hris.certificates.create', $nik) }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Sertifikat
                </a>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Nomor</th>
                        <th>Masa Berlaku</th>
                        <th>Dokumen</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($certificates as $cert)
                        <tr>
                            <td>{{ $cert->category?->name ?? '-' }}</td>
                            <td>{{ $cert->type }}</td>
                            <td>{{ $cert->number }}</td>
                            <td>{{ \Carbon\Carbon::parse($cert->expiry_date)->format('d/m/Y') }}</td>
                               <td>
                                @if ($cert->document_path)
                                    <a href="{{ $cert->document_url }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-file-pdf"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>{!! $cert->status_badge !!}</td>
                            <td>
                                <a href="{{ $cert->document_url }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <a href="{{ route('hris.certificates.edit', [$nik, $cert->id]) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('hris.certificates.destroy', [$nik, $cert->id]) }}" method="POST"
                                    style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
