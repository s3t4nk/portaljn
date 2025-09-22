@extends('layouts.hris')

@section('title', 'Detail Karyawan: ' . $employee->name)
@section('content_header')
    <h1><i class="fas fa-user-tie"></i> Detail Karyawan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/portal">Portal</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hris.employees.index') }}">Karyawan</a></li>
            <li class="breadcrumb-item active">{{ $employee->name }}</li>
        </ol>
    </nav>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <div class="row">
        <!-- Avatar & Info Singkat -->
        <div class="col-md-4">
            <div class="card card-widget widget-user shadow">
                <div class="widget-user-header bg-gradient-info">
                    <h3 class="widget-user-username">{{ $employee->name }}</h3>
                    <h5 class="widget-user-desc">{{ $employee->position?->name ?? '-' }}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle elevation-2"
                        src="https://ui-avatars.com/api/?name={{ urlencode($employee->name) }}&background=3f679c&color=fff"
                        alt="User Avatar">
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6 border-right">
                            <div class="description-block">
                                <span class="description-text">NIK</span>
                                <h5 class="description-header">{{ $employee->employee_number }}</h5>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="description-block">
                                <span class="description-text">Status</span>
                                <h5 class="description-header">
                                    <span
                                        class="badge badge-{{ $employee->employment_status == 'tetap'
                                            ? 'success'
                                            : ($employee->employment_status == 'kontrak'
                                                ? 'warning'
                                                : 'secondary') }}">
                                        {{ ucfirst($employee->employment_status) }}
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Info -->
        <div class="col-md-8">
            <div class="card card-outline card-dark">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'personal' ? 'active' : '' }}" href="#personal"
                                data-toggle="tab">Data Pribadi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'work' ? 'active' : '' }}" href="#work"
                                data-toggle="tab">Pekerjaan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'docs' ? 'active' : '' }}" href="#docs"
                                data-toggle="tab">Dokumen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $activeTab == 'salary' ? 'active' : '' }}" href="#salary"
                                data-toggle="tab">Gaji & Histori</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Tab 1: Personal -->
                        <div class="tab-pane {{ $activeTab == 'personal' ? 'active show' : '' }}" id="personal">
                            <dl class="row">
                                <dt class="col-sm-4">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-8">{{ $employee->birth_place }},
                                    {{ \Carbon\Carbon::parse($employee->birth_date)->format('d M Y') }}</dd>

                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">{{ $employee->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>

                                <dt class="col-sm-4">Agama</dt>
                                <dd class="col-sm-8">{{ $employee->religion }}</dd>

                                <dt class="col-sm-4">Gol. Darah</dt>
                                <dd class="col-sm-8">{{ $employee->blood_type ?? '-' }}</dd>

                                <dt class="col-sm-4">Status Nikah</dt>
                                <dd class="col-sm-8">{{ ucfirst(str_replace('_', ' ', $employee->marital_status)) }}</dd>

                                <dt class="col-sm-4">Email</dt>
                                <dd class="col-sm-8">{{ $employee->email ?? '-' }}</dd>
                            </dl>
                        </div>

                        <!-- Tab 2: Work -->
                        <div class="tab-pane {{ $activeTab == 'work' ? 'active show' : '' }}" id="work">
                            <dl class="row">
                                <dt class="col-sm-4">Cabang</dt>
                                <dd class="col-sm-8">{{ $employee->branch?->name ?? '-' }}</dd>

                                <dt class="col-sm-4">Divisi</dt>
                                <dd class="col-sm-8">{{ $employee->department?->name ?? '-' }}</dd>

                                <dt class="col-sm-4">Unit</dt>
                                <dd class="col-sm-8">{{ $employee->unit?->name ?? '-' }}</dd>

                                <dt class="col-sm-4">Jabatan</dt>
                                <dd class="col-sm-8">
                                    <strong>{{ $employee->position?->name ?? '-' }}</strong>
                                    <br>
                                    <small>{{ $employee->position?->code ?? '-' }}</small>
                                </dd>

                                <dt class="col-sm-4">TMT Kerja</dt>
                                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($employee->joining_date)->format('d M Y') }}
                                </dd>
                            </dl>
                        </div>

                        <!-- Tab 3: Docs -->
                        <div class="tab-pane {{ $activeTab == 'docs' ? 'active show' : '' }}" id="docs">
                            <dl class="row">
                                <dt class="col-sm-4">NIK KTP</dt>
                                <dd class="col-sm-8">{{ $employee->id_card_number }}</dd>

                                <dt class="col-sm-4">KK</dt>
                                <dd class="col-sm-8">{{ $employee->family_card_number ?? '-' }}</dd>

                                <dt class="col-sm-4">NPWP</dt>
                                <dd class="col-sm-8">{{ $employee->npwp_number ?? '-' }}</dd>

                                <dt class="col-sm-4">BPJS Ketenagakerjaan</dt>
                                <dd class="col-sm-8">{{ $employee->bpjs_ketenagakerjaan ?? '-' }}</dd>

                                <dt class="col-sm-4">BPJS Kesehatan</dt>
                                <dd class="col-sm-8">{{ $employee->bpjs_kesehatan ?? '-' }}</dd>

                                <dt class="col-sm-4">Kontak Darurat</dt>
                                <dd class="col-sm-8">
                                    {{ $employee->emergency_contact_name }}<br>
                                    Hubungan: {{ $employee->emergency_contact_relation }}<br>
                                    No: {{ $employee->emergency_contact_phone }}
                                </dd>
                            </dl>
                        </div>

                        <!-- Tab: Gaji -->
                        <div class="tab-pane {{ $activeTab == 'salary' ? 'active show' : '' }}" id="salary">
                            <div class="row">
                                <!-- Struktur Gaji -->
                                <div class="col-md-6">
                                    <div class="card bg-gradient-info">
                                        <div class="card-header">
                                            <h5 class="card-title">Struktur Gaji Terkini</h5>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Gaji Pokok:</strong> Rp {{ number_format($base, 0, ',', '.') }}</p>
                                            @foreach ($components as $comp)
                                                <p><strong>{{ $comp['name'] }}:</strong> Rp
                                                    {{ number_format($comp['value'], 0, ',', '.') }}</p>
                                            @endforeach
                                            <hr>
                                            <p><strong>Total Estimasi:</strong> <strong>Rp
                                                    {{ number_format($total, 0, ',', '.') }}</strong></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Histori Gaji -->
                                <div class="col-md-6">
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">Histori Gaji</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <table id="salaryHistoryTable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Bulan</th>
                                                        <th>Total Gaji</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($employee->salaryHistories as $hist)
                                                        <tr>
                                                            <td>{{ \Carbon\Carbon::parse($hist->period . '-01')->locale('id')->format('F Y') }}
                                                            </td>
                                                            <td><strong>Rp
                                                                    {{ number_format($hist->total_salary, 0, ',', '.') }}</strong>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    class="badge badge-{{ $hist->status == 'paid' ? 'success' : ($hist->status == 'published' ? 'info' : 'warning') }}">
                                                                    {{ ucfirst($hist->status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <td>
                                                <div class="row mt-3">
                                                    <div class="col-12 text-right">
                                                        <a href="{{ route('hris.employees.slip', $employee->id) }}"
                                                            class="btn btn-success mr-2" target="_blank">
                                                            <i class="fas fa-file-pdf"></i> Download Slip Gaji
                                                        </a>
                                                        <a href="{{ route('hris.employees.edit', $employee) }}"
                                                            class="btn btn-warning mr-2">
                                                            <i class="fas fa-edit"></i> Edit Data
                                                        </a>
                                                        <a href="{{ route('hris.employees.index') }}"
                                                            class="btn btn-secondary">
                                                            <i class="fas fa-arrow-left"></i> Kembali
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Struktur Gaji</h3>
                </div>
                <div class="card-body">
                    <p><strong>Gaji Pokok:</strong> Rp
                        {{ number_format($employee->position?->salaryGrade?->base_salary ?? 0, 0, ',', '.') }}</p>
                    <p><strong>Total Estimasi Gaji:</strong> <strong>Rp
                            {{ number_format($employee->total_salary, 0, ',', '.') }}</strong></p>
                    <small class="text-muted">Termasuk tunjangan berdasarkan grade, jabatan, dan tipe pegawai.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12 text-right">
            <a href="{{ route('hris.employees.edit', $employee) }}" class="btn btn-warning mr-2">
                <i class="fas fa-edit"></i> Edit Data
            </a>
            <a href="{{ route('hris.employees.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@stop



@section('js')
    <script>
        $(function() {
            $('#salaryHistoryTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
                }
            });
        });
    </script>
    <script>
        $('.alert').delay(3000).fadeOut();
    </script>
@stop
