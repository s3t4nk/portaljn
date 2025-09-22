@extends('adminlte::page')
@section('title', 'Manajemen Menu')

@section('content_header')
    <h1><i class="fas fa-cogs"></i> Manajemen Menu Sistem</h1>
    <a href="{{ route('hris.admin.menu.create.module') }}" class="btn btn-primary mt-2">
        <i class="fas fa-plus"></i> Tambah Modul
    </a>
    <a href="{{ route('hris.admin.menu.create.menu') }}" class="btn btn-success mt-2">
        <i class="fas fa-plus"></i> Tambah Menu
    </a>
@stop

@section('content')
    @foreach ($modules as $module)
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">{{ $module->name }} ({{ $module->slug }})</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Teks</th>
                            <th>URL</th>
                            <th>Icon</th>
                            <th>Permission</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($module->menus as $item)
                            @if (!$item->parent_id)
                                <tr>
                                    <td>{{ $item->text }}</td>
                                    <td>{{ $item->url }}</td>
                                    <td><i class="{{ $item->icon }}"></i> {{ $item->icon }}</td>
                                    <td><code>{{ $item->permission }}</code></td>
                                    <td>
                                        <a href="{{ route('hris.admin.menu.edit.menu', $item) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('hris.admin.menu.destroy', $item) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @foreach ($item->children as $child)
                                    <tr class="bg-light">
                                        <td>&nbsp;&nbsp;&nbsp;↳ {{ $child->text }}</td>
                                        <td>{{ $child->url }}</td>
                                        <td><i class="{{ $child->icon }}"></i> {{ $child->icon }}</td>
                                        <td><code>{{ $child->permission }}</code></td>
                                        <td>
                                            <a href="{{ route('hris.admin.menu.edit.menu', $child) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('hris.admin.menu.destroy', $child) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@stop