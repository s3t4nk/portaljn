@extends('layouts.app')

@section('title', 'Tambah Modul Baru')

@section('content_header')
    <h1><i class="fas fa-cube"></i> Tambah Modul</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('portal.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hris.admin.menu.index') }}">Manajemen Menu</a></li>
        <li class="breadcrumb-item active">Tambah Modul</li>
    </ol>
@stop

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Modul</h3>
        </div>
        <form action="{{ route('hris.admin.menu.store.module') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Modul</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Slug (untuk URL)</label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" required>
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Icon (Font Awesome)</label>
                    <input type="text" name="icon" class="form-control" placeholder="contoh: fas fa-users" value="{{ old('icon') }}">
                    <small class="text-muted">Lihat daftar icon di <a href="https://fontawesome.com/v5/icons" target="_blank">fontawesome.com</a></small>
                </div>

                <div class="form-group">
                    <label>Urutan</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                </div>

                <div class="form-check mb-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Modul</button>
                <a href="{{ route('hris.admin.menu.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop