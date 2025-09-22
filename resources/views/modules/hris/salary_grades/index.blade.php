@extends('layouts.hris')

@section('title', 'Manajemen Grade Gaji')
@section('content_header')
    <h1><i class="fas fa-coins"></i> Daftar Grade Gaji</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/portal">Portal</a></li>
            <li class="breadcrumb-item active">Grade Gaji</li>
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

    <div class="card card-outline card-secondary">
        <div class="card-header">
            <h3 class="card-title">Data Struktur Gaji (I s/d VII)</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal-create">
                    <i class="fas fa-plus"></i> Tambah Baru
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="table-salary-grades" class="table table-bordered table-striped">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>Kode</th>
                        <th>Grade</th>
                        <th>Kelas</th>
                        <th>Subkelas</th>
                        <th>Gaji Pokok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salaryGrades as $sg)
                    <tr>
                        <td><strong>{{ $sg->code }}</strong></td>
                        <td>{{ $sg->grade }}</td>
                        <td>{{ $sg->class }}</td>
                        <td>{{ $sg->subclass }}</td>
                        <td>Rp {{ number_format($sg->base_salary, 0, ',', '.') }}</td>
                        <td class="text-center" style="width: 15%;">
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                data-target="#modal-edit"
                                data-id="{{ $sg->id }}"
                                data-grade="{{ $sg->grade }}"
                                data-class="{{ $sg->class }}"
                                data-subclass="{{ $sg->subclass }}"
                                data-base_salary="{{ $sg->base_salary }}"
                                data-description="{{ $sg->description }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('hris.salary_grades.destroy', $sg) }}" method="POST" style="display:inline;">
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
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('hris.salary_grades.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Grade Gaji Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Grade (1-7)</label>
                                    <input type="number" name="grade" class="form-control" min="1" max="7" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kelas (A/B/C/D)</label>
                                    <select name="class" class="form-control" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Subkelas (1/2/3)</label>
                            <input type="number" name="subclass" class="form-control" min="1" max="3" required>
                        </div>
                        <div class="form-group">
                            <label>Gaji Pokok</label>
                            <input type="number" name="base_salary" class="form-control" required step="1000" placeholder="misal: 8000000">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-edit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Grade Gaji</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Grade (1-7)</label>
                                    <input type="number" name="grade" id="edit-grade" class="form-control" min="1" max="7" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kelas (A/B/C/D)</label>
                                    <select name="class" id="edit-class" class="form-control" required>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Subkelas (1/2/3)</label>
                            <input type="number" name="subclass" id="edit-subclass" class="form-control" min="1" max="3" required>
                        </div>
                        <div class="form-group">
                            <label>Gaji Pokok</label>
                            <input type="number" name="base_salary" id="edit-base_salary" class="form-control" required step="1000">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="description" id="edit-description" class="form-control" rows="3"></textarea>
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

@section('js')
    <script>
        // Isi modal edit
        $('#modal-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var grade = button.data('grade');
            var class_val = button.data('class');
            var subclass = button.data('subclass');
            var base_salary = button.data('base_salary');
            var description = button.data('description');

            var action = "{{ url('/hris/salary-grades') }}/" + id;

            var modal = $(this);
            modal.find('#edit-grade').val(grade);
            modal.find('#edit-class').val(class_val);
            modal.find('#edit-subclass').val(subclass);
            modal.find('#edit-base_salary').val(base_salary);
            modal.find('#edit-description').val(description);
            modal.find('#form-edit').attr('action', action);
        });

        // Inisialisasi DataTable
        $(function () {
            $('#table-salary-grades').DataTable({
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
@stop