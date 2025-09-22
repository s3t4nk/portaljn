@extends('adminlte::page')
@section('title', 'Tambah Modul')

@section('content_header')
    <h1>Edit Modul</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('hris.admin.module.storeModule') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Modul</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Icon (Font Awesome)</label>
                    <input type="text" name="icon" class="form-control" placeholder="fas fa-users">
                </div>
                <div class="form-group">
                    <label>Urutan</label>
                    <input type="number" name="order" class="form-control" value="0">
                </div>
                <div class="form-group">
                    <label>Status Aktif</label>
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