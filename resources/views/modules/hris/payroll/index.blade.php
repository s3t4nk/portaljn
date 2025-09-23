@extends('layouts.hris')

@section('title', 'Payroll Bulanan')

@section('content_header')
    <h1><i class="fas fa-calculator"></i> Payroll Bulanan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/portal">Portal</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hris.dashboard') }}">HRIS</a></li>
            <li class="breadcrumb-item active">Payroll</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="row">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif
                    <h3 class="card-title">Daftar Payroll @php
                        try {
                            $date = \Carbon\Carbon::createFromFormat(
                                'Y-m',
                                str_pad($hist->period, 7, '0', STR_PAD_RIGHT),
                            );
                            $formattedPeriod = $date->format('F Y');
                        } catch (\Exception $e) {
                            $formattedPeriod = 'Periode Tidak Valid';
                        }
                    @endphp
                        <td>{{ $formattedPeriod }}</td>
                    </h3>
                    <form method="POST" action="{{ route('hris.payroll.generate') }}" class="mb-3">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <input type="month" name="period" class="form-control"
                                    value="{{ request('period', now()->format('Y-m')) }}" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">Generate Payroll</button>
                            </div>
                        </div>
                    </form>
                    <div class="card-tools">
                        <form method="GET" class="input-group input-group-sm" style="width: 250px;">
                            <input type="month" name="period" class="form-control"
                                value="{{ request('period', now()->format('Y-m')) }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>

                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>Nama Karyawan</th>
                                <th>Gaji Pokok</th>
                                <th>Total Gaji</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payrolls as $p)
                                <tr>
                                    <td><input type="checkbox" name="ids[]" value="{{ $p->id }}"></td>
                                    <td>{{ $p->employee->name }}</td>
                                    <td>Rp {{ number_format($p->base_salary, 0, ',', '.') }}</td>
                                    <td><strong>Rp {{ number_format($p->total_salary, 0, ',', '.') }}</strong></td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $p->status == 'paid' ? 'success' : ($p->status == 'published' ? 'info' : 'warning') }}">
                                            {{ ucfirst($p->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($p->status == 'draft')
                                            <form method="POST" action="{{ route('hris.payroll.publish', $p) }}"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-info">Publish</button>
                                            </form>
                                        @elseif($p->status == 'published')
                                            <form method="POST" action="{{ route('hris.payroll.pay', $p) }}"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">Bayar</button>
                                            </form>
                                        @elseif($p->status == 'paid')
                                            <span class="badge badge-success">Sudah Dibayar</span>
                                            <!-- Tidak ada tombol, tidak bisa diubah -->
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data payroll untuk periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Tombol Approve Massal -->
                    @if ($payrolls->count() > 0 && $payrolls->where('status', 'draft')->count() > 0)
                        <form method="POST" action="{{ route('hris.payroll.approve-mass') }}" class="mt-3">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check-circle"></i> Approve Semua Draft
                                    </button>
                                </div>
                                <div class="col-md-4 text-right">
                                    <small class="text-muted">
                                        Pilih semua yang ingin diapprove.
                                    </small>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="card-footer">
                    {{ $payrolls->links() }}
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
<script>
$(document).ready(function() {
    // Select All
    $('#select-all').on('click', function() {
        $('input[name="ids[]"]').prop('checked', $(this).prop('checked'));
    });

    // DataTable
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
@stop