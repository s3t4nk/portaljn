@extends('layouts.hris')

@section('title', 'Edit Modul')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Modul</h1>
        </div>
        <div class="col-sm-6">
            <div class="float-right">
                <a href="{{ route('hris.admin.menu.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route('hris.admin.menu.update.module', $module) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Modul</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $module->name) }}" required>
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $module->slug) }}" required>
                </div>
                <div class="form-group">
                    <label>Icon (Font Awesome)</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $module->icon) }}">
                    <small class="text-muted">Contoh: fas fa-users</small>
                </div>
                <div class="form-check mb-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $module->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Perbarui Modul</button>
            </div>
        </form>
    </div>
@stop