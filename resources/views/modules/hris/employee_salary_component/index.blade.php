@extends('layouts.hris')

@section('content')
<div class="container">
    <h4>Komponen Gaji - {{ $employee->name }} ({{ $employee->employee_number }})</h4>

    {{-- Form tambah komponen --}}
    <form action="{{ route('hris.employee-salary-component.store', $employee->id) }}" method="POST">
        <div class="row">
            <div class="col-md-6">
                <label>Komponen</label>
                <select name="salary_component_id" class="form-control" required>
                    <option value="">-- Pilih Komponen --</option>
                    @foreach($allComponents as $c)
                        <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->category }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Nominal</label>
                <input type="number" name="amount" class="form-control" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-success w-100">Tambah</button>
            </div>
        </div>
    </form>

    {{-- Tabel komponen --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Komponen</th>
                <th>Kategori</th>
                <th>Nominal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($components as $comp)
                <tr>
                    <td>{{ $comp->name }}</td>
                    <td>{{ ucfirst($comp->category) }}</td>
                    <td>
                        <form method="POST" action="{{ route('hris.employee-salary-component.update', [$employee->id, $comp->id]) }}" class="d-flex">
                            @csrf @method('PUT')
                            <input type="number" name="amount" value="{{ $comp->amount }}" class="form-control me-2">
                            <button class="btn btn-primary btn-sm">Simpan</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('hris.employee-salary-component.destroy', [$employee->id, $comp->id]) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
