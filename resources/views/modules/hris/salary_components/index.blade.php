@extends('layouts.hris')

@section('title', 'Manajemen Komponen Gaji')
@section('content_header')
    <h1><i class="fas fa-dollar-sign"></i> Komponen Gaji & Tunjangan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/portal">Portal</a></li>
            <li class="breadcrumb-item active">Komponen Gaji</li>
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

    <div class="card card-outline card-purple">
        <div class="card-header">
            <h3 class="card-title">Daftar Tunjangan & Komponen Gaji</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-purple" data-toggle="modal" data-target="#modal-create">
                    <i class="fas fa-plus"></i> Tambah Baru
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="table-salary-components" class="table table-bordered table-striped">
                <thead class="bg-purple text-white">
                    <tr>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Nominal</th>
                        <th>Berlaku Untuk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($components as $comp)
                        <tr>
                            <td><strong>{{ $comp->name }}</strong></td>
                            <td>{{ ucfirst($comp->type) }}</td>
                            <td>
                                @if ($comp->type == 'percentage')
                                    {{ $comp->amount }}%
                                @else
                                    Rp {{ number_format($comp->amount, 0, ',', '.') }}
                                @endif
                            </td>
                            <td>
                                @if ($comp->applicable_to == 'grade')
                                    Grade {{ $comp->min_grade ?? '-' }} s/d {{ $comp->max_grade ?? '-' }}
                                @elseif($comp->applicable_to == 'position')
                                    {{ $comp->position?->name ?? '-' }}
                                @else
                                    {{ ucfirst($comp->employee_type) }}
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $comp->is_active ? 'success' : 'danger' }}">
                                    {{ $comp->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center" style="width: 15%;">
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                    data-target="#modal-edit" data-id="{{ $comp->id }}"
                                    data-name="{{ $comp->name }}" data-type="{{ $comp->type }}"
                                    data-amount="{{ $comp->amount }}" data-applicable_to="{{ $comp->applicable_to }}"
                                    data-min_grade="{{ $comp->min_grade }}" data-max_grade="{{ $comp->max_grade }}"
                                    data-position_id="{{ $comp->position_id }}"
                                    data-employee_type="{{ $comp->employee_type }}"
                                    data-description="{{ $comp->description }}" data-is_active="{{ $comp->is_active }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('hris.salary_components.destroy', $comp) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="modal-create">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('hris.salary_components.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Komponen Gaji Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Komponen</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Tunjangan Jabatan, Pendidikan, dll" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
                                <select name="category" class="form-control" required>
                                    <option value="allowance">Tunjangan</option>
                                    <option value="deduction">Potongan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe</label>
                                    <select name="type" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="fixed">Nominal Tetap</option>
                                        <option value="percentage">Persentase dari Gaji Pokok</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nominal / Persentase</label>
                            <input type="number" step="0.01" name="amount" class="form-control" required
                                placeholder="misal: 1500000 atau 10 untuk 10%">
                        </div>
                        <div class="form-group">
                            <label>Berlaku Untuk</label>
                            <select name="applicable_to" id="applicable_to" class="form-control" required>
                                <option value="">-- Pilih Aturan Berlaku --</option>
                                <option value="grade">Grade (I-VII)</option>
                                <option value="position">Jabatan Tertentu</option>
                                <option value="employee_type">Tipe Pegawai (Darat/Laut)</option>
                            </select>
                        </div>

                        <!-- Grade Range -->
                        <div id="section-grade" class="d-none">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Min Grade</label>
                                        <input type="number" name="min_grade" class="form-control" min="1"
                                            max="7">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Maks Grade</label>
                                        <input type="number" name="max_grade" class="form-control" min="1"
                                            max="7">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Position -->
                        <div id="section-position" class="d-none">
                            <div class="form-group">
                                <label>Jabatan</label>
                                <select name="position_id" class="form-control">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($positions as $pos)
                                        <option value="{{ $pos->id }}">{{ $pos->name }} ({{ $pos->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Employee Type -->
                        <div id="section-employee_type" class="d-none">
                            <div class="form-group">
                                <label>Tipe Pegawai</label>
                                <select name="employee_type" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="darat">Darat</option>
                                    <option value="laut">Laut</option>
                                    <option value="semua">Semua</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input" checked>
                            <label class="form-check-label">Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form-edit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Komponen Gaji</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Komponen</label>
                                    <input type="text" name="name" id="edit-name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe</label>
                                    <select name="type" id="edit-type" class="form-control" required>
                                        <option value="fixed">Nominal Tetap</option>
                                        <option value="percentage">Persentase</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nominal / Persentase</label>
                            <input type="number" step="0.01" name="amount" id="edit-amount" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Berlaku Untuk</label>
                            <select name="applicable_to" id="edit-applicable_to" class="form-control" required>
                                <option value="grade">Grade (I-VII)</option>
                                <option value="position">Jabatan Tertentu</option>
                                <option value="employee_type">Tipe Pegawai</option>
                            </select>
                        </div>

                        <div id="edit-section-grade" class="d-none">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Min Grade</label>
                                        <input type="number" name="min_grade" id="edit-min_grade" class="form-control"
                                            min="1" max="7">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Maks Grade</label>
                                        <input type="number" name="max_grade" id="edit-max_grade" class="form-control"
                                            min="1" max="7">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="edit-section-position" class="d-none">
                            <div class="form-group">
                                <label>Jabatan</label>
                                <select name="position_id" id="edit-position_id" class="form-control">
                                    <option value="">-- Pilih Jabatan --</option>
                                    @foreach ($positions as $pos)
                                        <option value="{{ $pos->id }}">{{ $pos->name }} ({{ $pos->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="edit-section-employee_type" class="d-none">
                            <div class="form-group">
                                <label>Tipe Pegawai</label>
                                <select name="employee_type" id="edit-employee_type" class="form-control">
                                    <option value="darat">Darat</option>
                                    <option value="laut">Laut</option>
                                    <option value="semua">Semua</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" id="edit-description" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="edit-is_active" value="1"
                                class="form-check-input">
                            <label class="form-check-label">Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        // Show/hide section based on applicable_to
        $('#applicable_to').change(function() {
            $('#section-grade, #section-position, #section-employee_type').addClass('d-none');
            if ($(this).val() === 'grade') $('#section-grade').removeClass('d-none');
            if ($(this).val() === 'position') $('#section-position').removeClass('d-none');
            if ($(this).val() === 'employee_type') $('#section-employee_type').removeClass('d-none');
        });

        $('#edit-applicable_to').change(function() {
            $('#edit-section-grade, #edit-section-position, #edit-section-employee_type').addClass('d-none');
            if ($(this).val() === 'grade') $('#edit-section-grade').removeClass('d-none');
            if ($(this).val() === 'position') $('#edit-section-position').removeClass('d-none');
            if ($(this).val() === 'employee_type') $('#edit-section-employee_type').removeClass('d-none');
        });

        // Isi modal edit
        $('#modal-edit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var type = button.data('type');
            var amount = button.data('amount');
            var applicable_to = button.data('applicable_to');
            var min_grade = button.data('min_grade');
            var max_grade = button.data('max_grade');
            var position_id = button.data('position_id');
            var employee_type = button.data('employee_type');
            var description = button.data('description');
            var is_active = button.data('is_active');

            var action = "{{ url('/hris/salary-components') }}/" + id;

            var modal = $(this);
            modal.find('#edit-name').val(name);
            modal.find('#edit-type').val(type);
            modal.find('#edit-amount').val(amount);
            modal.find('#edit-applicable_to').val(applicable_to).trigger('change');
            modal.find('#edit-min_grade').val(min_grade);
            modal.find('#edit-max_grade').val(max_grade);
            modal.find('#edit-position_id').val(position_id);
            modal.find('#edit-employee_type').val(employee_type);
            modal.find('#edit-description').val(description);
            modal.find('#edit-is_active').prop('checked', is_active == 1);
            modal.find('#form-edit').attr('action', action);
        });

        // Inisialisasi DataTable
        $(function() {
            $('#table-salary-components').DataTable({
                "paging": true,
                "lengthChange": true,
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

        // Auto-close alert
        $('.alert').delay(3000).fadeOut();
    </script>
@endpush
    
