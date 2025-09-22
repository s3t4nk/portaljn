@extends('adminlte::page')
@section('title', 'Tambah Menu')

@section('content_header')
    <h1>Tambah Menu Baru</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('hris.admin.menu.storeMenu') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Modul</label>
                    <select name="module_id" class="form-control" required>
                        @foreach($modules as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Teks Menu</label>
                    <input type="text" name="text" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>URL</label>
                    <input type="text" name="url" class="form-control" placeholder="/hris/employees">
                </div>
                <div class="form-group">
                    <label>Icon</label>
                    <input type="text" name="icon" class="form-control" placeholder="fas fa-building">
                </div>
                <div class="form-group">
                    <label>Parent (Submenu)</label>
                    <select name="parent_id" class="form-control">
                        <option value="">-- Menu Utama --</option>
                        @foreach($parents as $id => $text)
                            <option value="{{ $id }}">{{ $text }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Permission</label>
                    <input type="text" name="permission" class="form-control" placeholder="manage-branch">
                </div>
                <div class="form-group">
                    <label>Urutan</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>
                <div class="form-group">
                    <label>Aktif?</label>
                    <input type="checkbox" name="is_active" value="1" checked>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('hris.admin.menu.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@stop