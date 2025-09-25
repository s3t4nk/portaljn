@extends('layouts.hris')

@section('content')
<div class="container">
    <h4>Daftar Pegawai - Kelola Komponen Gaji</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Unit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $emp)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $emp->employee_number ?? '-' }}</td>
                    <td>{{ $emp->name }}</td>
                    <td>{{ $emp->position->name ?? '-' }}</td>
                    <td>{{ $emp->unit->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('hris.employee-salary-component.index', $emp->id) }}" class="btn btn-sm btn-primary">
                            Kelola Komponen
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
