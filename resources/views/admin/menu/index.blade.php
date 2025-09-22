@extends('adminlte::page')

@section('title', 'Manajemen Menu')

@section('content_header')
    <h1><i class="fas fa-cogs"></i> Manajemen Menu</h1>
    <a href="{{ route('hris.admin.menu.createModule') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Modul
    </a>
    <a href="{{ route('hris.admin.menu.createMenu') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Tambah Menu
    </a>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card card-outline card-info">
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama Modul</th>
                        <th>Slug</th>
                        <th>Icon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modules as $module)
                        <tr>
                            <td>{{ $module->name }}</td>
                            <td>{{ $module->slug }}</td>
                            <td><i class="{{ $module->icon }}"></i></td>
                            <td>
                                <a href="{{ route('hris.admin.menu.editModule', $module) }}" class="btn btn-xs btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('hris.admin.menu.destroyModule', $module) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus modul ini?')">
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

@section('css')
    <style>
        .btn-xs {
            padding: .25rem .4rem;
            font-size: .875rem;
        }
    </style>
@stop