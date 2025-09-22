@extends('layouts.hris')

@section('title', 'Manajemen Menu')

@section('content_header')
    <h1><i class="fas fa-cogs"></i> Manajemen Menu Sistem</h1>

    <!-- ✅ Ganti route Tambah Modul & Tambah Menu -->
    <a href="{{ route('hris.admin.menu.module.create') }}" class="btn btn-primary mt-2">
        <i class="fas fa-plus"></i> Tambah Modul
    </a>
    <a href="{{ route('hris.admin.menu.menu.create') }}" class="btn btn-success mt-2">
        <i class="fas fa-plus"></i> Tambah Menu
    </a>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($modules as $module)
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">{{ $module->name }} ({{ $module->slug }})</h3>
            </div>
            <div
                style="position: fixed; top: 10px; right: 10px; background: white; border: 1px solid #ccc; padding: 10px; z-index: 9999;">
                <strong>User:</strong> {{ auth()->user()->name }}<br>
                <strong>Role:</strong>
                @foreach (auth()->user()->getRoleNames() as $role)
                    <span class="badge bg-primary">{{ $role }}</span>
                @endforeach
                <br>
                <strong>Permissions:</strong>
                @foreach (auth()->user()->getAllPermissions() as $permission)
                    <span class="badge bg-info">{{ $permission->name }}</span>
                @endforeach
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
                                        <!-- ✅ Ganti $menu jadi $item -->
                                        <a href="{{ route('hris.admin.menu.menu.edit', $item) }}"
                                            class="btn btn-xs btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('hris.admin.menu.menu.destroy', $item) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus?')">
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
                                            <!-- ✅ Ganti $menu jadi $child -->
                                            <a href="{{ route('hris.admin.menu.menu.edit', $child) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('hris.admin.menu.menu.destroy', $child) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Hapus?')">
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
