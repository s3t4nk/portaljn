@extends('layouts.hris')

@section('title', 'Tambah Modul')

@section('content_header')
    <h1>Tambah Modul Baru</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('hris.admin.menu.module.store') }}" method="POST">
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
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Simpan Modul</button>
                <a href="{{ route('hris.admin.menu.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop