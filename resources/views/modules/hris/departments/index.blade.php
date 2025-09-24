@extends('layouts.hris')

@section('title', 'Manajemen Departemen')
@section('content_header')
    <h1><i class="fas fa-sitemap"></i> Daftar Departemen</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/portal">Portal</a></li>
            <li class="breadcrumb-item active">Departemen</li>
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

    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Data Departemen</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-create">
                    <i class="fas fa-plus"></i> Tambah Baru
                </button>
            </div>
        </div>

        <div class="card-body">
            <table id="table-departments" class="table table-bordered table-striped">
                <thead class="bg-info text-white">
                    <tr>
                        <th>Nama</th>
                        <th>Cabang/Kapal</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $dept)
                        <tr>
                            <td>{{ $dept->name }}</td>
                            <td>{{ $dept->branch?->name ?? '-' }}</td>
                            <td>{{ Str::limit($dept->description, 80) }}</td>
                            <td class="text-center" style="width: 15%;">
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                    data-target="#modal-edit" data-id="{{ $dept->id }}" data-name="{{ $dept->name }}"
                                    data-branch_id="{{ $dept->branch_id }}" data-description="{{ $dept->description }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('hris.departments.destroy', $dept) }}" method="POST"
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
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('hris.departments.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Departemen Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Departemen</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Cabang / Kantor Pusat / Kapal</label>
                            <select name="branch_id" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}
                                        ({{ ucfirst($branch->type) }})
                                    </option>
                                @endforeach
                            </select>
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
                    <input type="hidden" id="edit-id" name="id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Departemen</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Departemen</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Cabang / Kantor Pusat / Kapal</label>
                            <select name="branch_id" id="edit-branch_id" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}
                                        ({{ ucfirst($branch->type) }})
                                    </option>
                                @endforeach
                            </select>
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

@push('js')
    <script>
        $(document).ready(function() {
            // Handle modal edit
            $('#modal-edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var name = button.data('name');
                var branch_id = button.data('branch_id');
                var description = button.data('description');

                // ✅ Pastikan id valid
                if (!id) {
                    alert('Error: ID departemen tidak ditemukan.');
                    return;
                }

                // ✅ Gunakan route() helper Laravel
                var action = "{{ route('hris.departments.update', ['department' => ':id']) }}".replace(
                    ':id', id);

                var modal = $(this);
                modal.find('#edit-name').val(name);
                modal.find('#edit-branch_id').val(branch_id);
                modal.find('#edit-description').val(description);
                modal.find('#form-edit').attr('action', action);
            });

            // DataTable
            $('#table-departments').DataTable({
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

            // Auto-close alert
            $('.alert').delay(3000).fadeOut();
        });
    </script>
@endpush
