@extends('layouts.hris')

@section('title', 'Edit Menu')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Menu</h1>
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
        <form action="{{ route('hris.admin.menu.update.menu', $menu) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label>Modul</label>
                    <select name="module_id" class="form-control" required onchange="this.form.submit()">
                        @foreach (\App\Models\Module::pluck('name', 'id') as $id => $name)
                            <option value="{{ $id }}" {{ $id == old('module_id', $menu->module_id) ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Teks Menu</label>
                    <input type="text" name="text" class="form-control" value="{{ old('text', $menu->text) }}" required>
                </div>

                <div class="form-group">
                    <label>URL</label>
                    <input type="text" name="url" class="form-control" value="{{ old('url', $menu->url) }}">
                </div>

                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $menu->icon) }}">
                    <small class="text-muted">Contoh: fas fa-home</small>
                </div>

                <div class="form-group">
                    <label>Parent Menu (Opsional)</label>
                    <select name="parent_id" class="form-control">
                        <option value="">-- Tidak punya parent --</option>
                        @foreach ($parents as $id => $text)
                            <option value="{{ $id }}" {{ $id == old('parent_id', $menu->parent_id) ? 'selected' : '' }}>{{ $text }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Urutan</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', $menu->order) }}" min="0">
                </div>

                <div class="form-group">
                    <label>Permission (opsional)</label>
                    <input type="text" name="permission" class="form-control" value="{{ old('permission', $menu->permission) }}">
                    <small class="text-muted">Digunakan untuk hak akses</small>
                </div>

                <div class="form-check mb-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Perbarui Menu</button>
            </div>
        </form>
    </div>
@stop