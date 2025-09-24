@extends('layouts.hris')

@section('title', 'Daftar Karyawan')
@section('content_header')
    <h1><i class="fas fa-users"></i> Manajemen Data Karyawan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/portal">Portal</a></li>
            <li class="breadcrumb-item active">Karyawan</li>
        </ol>
    </nav>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Data Seluruh Karyawan</h3>
            <div class="card-tools">
                <a href="{{ route('hris.employees.create') }}" class="btn btn-sm btn-info">
                    <i class="fas fa-plus"></i> Tambah Baru
                </a>
            </div>
        </div>

        <div class="card-body p-0">
            <table id="table-employees" class="table table-striped table-hover mb-0">
                <thead class="bg-info text-white">
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Unit Kerja</th>
                        <th>Divisi</th>
                        <th>Status</th>
                        <th>TMT Kerja</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $emp)
                    <tr>
                        <td><strong>{{ $emp->employee_number }}</strong></td>
                        <td>{{ $emp->name }}</td>
                        <td>{{ $emp->position?->name ?? '-' }}</td>
                        <td>{{ $emp->unit?->name ?? $emp->department?->name ?? '-' }}</td>
                        <td>{{ $emp->department?->name ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ 
                                $emp->employment_status == 'tetap' ? 'success' : 
                                ($emp->employment_status == 'kontrak' ? 'warning' : 'secondary') 
                            }}">
                                {{ ucfirst($emp->employment_status) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($emp->joining_date)->format('d M Y') }}</td>
                        <td class="text-center" style="width: 15%;">
                            <a href="{{ route('hris.employees.show', $emp) }}" class="btn btn-sm btn-primary" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('hris.employees.edit', $emp) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('hris.employees.destroy', $emp) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Hapus karyawan ini?')">
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

@push('css')
    <style>
        .btn-circle {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
    </style>
@endpush
    
@push('js')
    <script>
        $(function () {
            $('#table-employees').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
                },
                "order": [[6, "desc"]] // Sort by joining_date desc
            });

            // Auto-close alert
            $('.alert').delay(3000).fadeOut();
        });
    </script>
@endpush