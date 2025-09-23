@extends('layouts.hris')

@section('title', 'Tambah Sertifikat')

@section('content_header')
    <h1>Tambah Sertifikat Baru</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('hris.certificates.store', $nik) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="category_id" class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Jenis Sertifikat</label>
                    <input type="text" name="type" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nomor Sertifikat</label>
                    <input type="text" name="number" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Terbit</label>
                    <input type="date" name="issued_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Masa Berlaku</label>
                    <input type="date" name="expiry_date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Lembaga Penerbit</label>
                    <input type="text" name="issuing_authority" class="form-control">
                </div>

                <div class="form-group">
                    <label>Upload Dokumen (PDF/JPG/PNG)</label>
                    <input type="file" name="document" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('hris.certificates.index', $nik) }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop
