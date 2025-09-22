@extends('layouts.hris')

@section('title', 'Dashboard HRIS')

@section('content_header')
    <h1>Dashboard HRIS</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
@stop

@section('content')
    <!-- Row 1: Statistik Utama -->
    <div class="row">
        <!-- Total Karyawan -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($totalEmployees) }}</h3>
                    <p>Total Karyawan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('hris.employees.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Karyawan Darat -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format($daratCount) }}</h3>
                    <p>Karyawan Darat</p>
                </div>
                <div class="icon">
                    <i class="fas fa-building"></i>
                </div>
                <a href="{{ route('hris.employees.index') }}?type=darat" class="small-box-footer">
                    Filter Darat <i class="fas fa-filter"></i>
                </a>
            </div>
        </div>

        <!-- Karyawan Laut -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($lautCount) }}</h3>
                    <p>Karyawan Laut</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ship"></i>
                </div>
                <a href="{{ route('hris.employees.index') }}?type=laut" class="small-box-footer">
                    Filter Laut <i class="fas fa-filter"></i>
                </a>
            </div>
        </div>

        <!-- Kantor Cabang -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($totalBranches) }}</h3>
                    <p>Kantor / Kapal</p>
                </div>
                <div class="icon">
                    <i class="fas fa-sitemap"></i>
                </div>
                <a href="{{ route('hris.branches.index') }}" class="small-box-footer">
                    Kelola Cabang <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Row 2: Payroll & Cuti -->
    <div class="row">
        <!-- Payroll Published -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-purple">
                <div class="inner">
                    <h3>{{ number_format($publishedPayrolls) }}</h3>
                    <p>Payroll Published</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="{{ route('hris.payroll.index') }}" class="small-box-footer">
                    Proses Gaji <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Cuti Menunggu -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($pendingLeaves) }}</h3>
                    <p>Cuti Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Proses Sekarang <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Row 1.5: Jenis Kelamin -->
        <!-- Karyawan Pria -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{ number_format($priaCount) }}</h3>
                    <p>Karyawan Pria</p>
                </div>
                <div class="icon">
                    <i class="fas fa-male"></i>
                </div>
                <a href="{{ route('hris.employees.index') }}?gender=L" class="small-box-footer">
                    Filter Pria <i class="fas fa-filter"></i>
                </a>
            </div>
        </div>

        <!-- Karyawan Wanita -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-pink">
                <div class="inner">
                    <h3>{{ number_format($wanitaCount) }}</h3>
                    <p>Karyawan Wanita</p>
                </div>
                <div class="icon">
                    <i class="fas fa-female"></i>
                </div>
                <a href="{{ route('hris.employees.index') }}?gender=P" class="small-box-footer">
                    Filter Wanita <i class="fas fa-filter"></i>
                </a>
            </div>
        </div>
    

    </div>

    

    <!-- Row 3: Distribusi Karyawan -->
    <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">Distribusi Karyawan per Cabang</h3>
                </div>
                <div class="card-body p-0">
                    @if ($employeesByBranch->isEmpty())
                        <p class="text-center p-3 text-muted">Tidak ada data</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($employeesByBranch as $branch)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $branch->branch_name }}
                                    <span class="badge badge-info">{{ $branch->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>



        <!-- Aktivitas Terbaru -->
        <div class="col-md-6">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Aktivitas Terbaru</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li><i class="fas fa-user-plus text-green"></i> Karyawan baru: Budi Santoso (Nakhoda)</li>
                        <li><i class="fas fa-file-alt text-blue"></i> Sertifikat hampir habis: Kapten Arif (Exp: 2025-12-01)
                        </li>
                        <li><i class="fas fa-calendar-times text-red"></i> Cuti diajukan: Rina (Staff SDM) - 5 hari</li>
                        <li><i class="fas fa-money-bill text-purple"></i> Payroll September di-publish</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 4: Quick Access -->
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-dark">
                <div class="card-header">
                    <h3 class="card-title">Pintasan Cepat</h3>
                </div>
                <div class="card-body text-center">
                    <div class="btn-group btn-group-lg" role="group">
                        <a href="{{ route('hris.employees.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Tambah Karyawan
                        </a>
                        <a href="{{ route('hris.payroll.index') }}" class="btn btn-success">
                            <i class="fas fa-calculator"></i> Penggajian
                        </a>
                        <a href="{{ route('hris.branches.index') }}" class="btn btn-warning">
                            <i class="fas fa-building"></i> Cabang
                        </a>
                        <a href="{{ route('hris.salary_components.index') }}" class="btn btn-info">
                            <i class="fas fa-list"></i> Komponen Gaji
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')

    <style>
        .small-box.bg-purple {
            background-color: #6f42c1 !important;
        }

        .small-box.bg-blue {
            background-color: #007bff !important;
        }

        .small-box.bg-pink {
            background-color: #e83e8c !important;
        }

        .small-box.bg-purple {
            background-color: #6f42c1 !important;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Dashboard HRIS dimuat");
        // Auto-hide alert
        $(document).ready(function() {
            $('.alert').delay(3000).fadeOut();
        });
    </script>
@stop
