@extends('layouts.hris')

@section('title', 'Manajemen Jabatan')
@section('content_header')
    <h1><i class="fas fa-briefcase"></i> Daftar Jabatan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/portal">Portal</a></li>
            <li class="breadcrumb-item active">Jabatan</li>
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

    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Data Jabatan & Struktur Gaji</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-create">
                    <i class="fas fa-plus"></i> Tambah Baru
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="table-positions" class="table table-bordered table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Jabatan</th>
                        <th>Grade Gaji</th>
                        <th>Tipe Pegawai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($positions as $pos)
                    <tr>
                        <td><strong>{{ $pos->code }}</strong></td>
                        <td>{{ $pos->name }}</td>
                        <td>{{ $pos->salaryGrade?->code ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $pos->employee_type == 'laut' ? 'danger' : ($pos->employee_type == 'darat' ? 'primary' : 'info') }}">
                                {{ ucfirst($pos->employee_type) }}
                            </span>
                        </td>
                        <td class="text-center" style="width: 15%;">
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                data-target="#modal-edit"
                                data-id="{{ $pos->id }}"
                                data-name="{{ $pos->name }}"
                                data-salary_grade_id="{{ $pos->salary_grade_id }}"
                                data-type="{{ $pos->type }}"
                                data-employee_type="{{ $pos->employee_type }}"
                                data-min_experience_years="{{ $pos->min_experience_years }}"
                                data-code="{{ $pos->code }}"
                                data-description="{{ $pos->description }}"
                                data-is_management="{{ $pos->is_management }}"
                                data-required_certifications='@json($pos->required_certifications)'>
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('hris.positions.destroy', $pos) }}" method="POST" style="display:inline;">
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
                <form action="{{ route('hris.positions.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jabatan Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Jabatan</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Jabatan</label>
                                    <input type="text" name="code" class="form-control" placeholder="misal: NAKHODA, BM-A" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Grade Gaji</label>
                                    <select name="salary_grade_id" class="form-control" required>
                                        <option value="">-- Pilih Grade --</option>
                                        @foreach($salaryGrades as $sg)
                                        <option value="{{ $sg->id }}">{{ $sg->code }} (Gaji: Rp {{ number_format($sg->base_salary, 0, ',', '.') }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe Jabatan</label>
                                    <select name="type" class="form-control" required>
                                        <option value="struktural">Struktural</option>
                                        <option value="fungsional">Fungsional</option>
                                        <option value="operasional">Operasional</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe Pegawai</label>
                                    <select name="employee_type" class="form-control" required>
                                        <option value="darat">Darat</option>
                                        <option value="laut">Laut</option>
                                        <option value="semua">Semua</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pengalaman Min (Tahun)</label>
                                    <input type="number" name="min_experience_years" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Sertifikasi Wajib (untuk Pelaut)</label>
                            <textarea name="required_certifications" class="form-control" rows="2" placeholder='["STCW", "BST"]'></textarea>
                            <small class="text-muted">Isi dalam format JSON, contoh: ["STCW", "PSCRB"]</small>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_management" value="1" class="form-check-input">
                            <label class="form-check-label">Jabatan Manajerial</label>
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
                        <h5 class="modal-title">Edit Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Jabatan</label>
                                    <input type="text" name="name" id="edit-name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode Jabatan</label>
                                    <input type="text" name="code" id="edit-code" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Grade Gaji</label>
                                    <select name="salary_grade_id" id="edit-salary_grade_id" class="form-control" required>
                                        <option value="">-- Pilih Grade --</option>
                                        @foreach($salaryGrades as $sg)
                                        <option value="{{ $sg->id }}">{{ $sg->code }} (Gaji: Rp {{ number_format($sg->base_salary, 0, ',', '.') }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe Jabatan</label>
                                    <select name="type" id="edit-type" class="form-control" required>
                                        <option value="struktural">Struktural</option>
                                        <option value="fungsional">Fungsional</option>
                                        <option value="operasional">Operasional</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipe Pegawai</label>
                                    <select name="employee_type" id="edit-employee_type" class="form-control" required>
                                        <option value="darat">Darat</option>
                                        <option value="laut">Laut</option>
                                        <option value="semua">Semua</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pengalaman Min (Tahun)</label>
                                    <input type="number" name="min_experience_years" id="edit-min_experience_years" class="form-control" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Sertifikasi Wajib (untuk Pelaut)</label>
                            <textarea name="required_certifications" id="edit-required_certifications" class="form-control" rows="2"></textarea>
                            <small class="text-muted">Format JSON, contoh: ["STCW", "BST"]</small>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" id="edit-description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_management" id="edit-is_management" value="1" class="form-check-input">
                            <label class="form-check-label">Jabatan Manajerial</label>
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
        // Isi modal edit
        $('#modal-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var salary_grade_id = button.data('salary_grade_id');
            var type = button.data('type');
            var employee_type = button.data('employee_type');
            var min_experience_years = button.data('min_experience_years');
            var code = button.data('code');
            var description = button.data('description');
            var is_management = button.data('is_management');
            var required_certifications = button.data('required_certifications');

            var action = "{{ url('/hris/positions') }}/" + id;

            var modal = $(this);
            modal.find('#edit-name').val(name);
            modal.find('#edit-salary_grade_id').val(salary_grade_id);
            modal.find('#edit-type').val(type);
            modal.find('#edit-employee_type').val(employee_type);
            modal.find('#edit-min_experience_years').val(min_experience_years);
            modal.find('#edit-code').val(code);
            modal.find('#edit-description').val(description);
            modal.find('#edit-required_certifications').val(JSON.stringify(required_certifications));
            modal.find('#edit-is_management').prop('checked', is_management == 1);
            modal.find('#form-edit').attr('action', action);
        });

        // Inisialisasi DataTable
        $(function () {
            $('#table-positions').DataTable({
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