@extends('layouts.hris')

@section('title', 'Manajemen Cabang & Kapal')
@section('content_header')
    <h1><i class="fas fa-building"></i> Daftar Cabang & Kapal</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/portal">Portal</a></li>
            <li class="breadcrumb-item active">Cabang & Kapal</li>
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

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Data Cabang, Kantor, dan Kapal</h3>
            <div class="card-tools">
                <!-- Tombol Tambah -->
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-create">
                    <i class="fas fa-plus"></i> Tambah Baru
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <table id="table-branches" class="table table-striped table-hover mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($branches as $branch)
                    <tr>
                        <td>{{ $branch->name }}</td>
                        <td><span class="badge badge-info">{{ ucfirst($branch->type) }}</span></td>
                        <td>{{ $branch->kelas ?? '-' }}</td>
                        <td>{{ Str::limit($branch->address, 50) }}</td>
                        <td>
                            <!-- Tombol Edit -->
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                data-target="#modal-edit"
                                data-id="{{ $branch->id }}"
                                data-name="{{ $branch->name }}"
                                data-type="{{ $branch->type }}"
                                data-kelas="{{ $branch->kelas }}"
                                data-address="{{ $branch->address }}"
                                data-phone="{{ $branch->phone }}"
                                data-latitude="{{ $branch->latitude }}"
                                data-longitude="{{ $branch->longitude }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('hris.branches.destroy', $branch) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')">
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
                <form action="{{ route('hris.branches.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Cabang/Kapal Baru</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="type" class="form-control" required>
                                <option value="">-- Pilih --</option>
                                <option value="pusat">Kantor Pusat</option>
                                <option value="cabang">Cabang</option>
                                <option value="kapal">Kapal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelas (A/B/C)</label>
                            <input type="text" name="kelas" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input type="number" step="any" name="latitude" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input type="number" step="any" name="longitude" class="form-control">
                                </div>
                            </div>
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
                        <h5 class="modal-title">Edit Cabang/Kapal</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="type" id="edit-type" class="form-control" required>
                                <option value="pusat">Kantor Pusat</option>
                                <option value="cabang">Cabang</option>
                                <option value="kapal">Kapal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelas (A/B/C)</label>
                            <input type="text" name="kelas" id="edit-kelas" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="address" id="edit-address" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon</label>
                            <input type="text" name="phone" id="edit-phone" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input type="number" step="any" name="latitude" id="edit-latitude" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input type="number" step="any" name="longitude" id="edit-longitude" class="form-control">
                                </div>
                            </div>
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
        // Isi data ke modal edit
        $('#modal-edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var name = button.data('name');
            var type = button.data('type');
            var kelas = button.data('kelas');
            var address = button.data('address');
            var phone = button.data('phone');
            var latitude = button.data('latitude');
            var longitude = button.data('longitude');

            var action = "{{ url('/hris/branches') }}/" + id;

            var modal = $(this);
            modal.find('#edit-name').val(name);
            modal.find('#edit-type').val(type);
            modal.find('#edit-kelas').val(kelas);
            modal.find('#edit-address').val(address);
            modal.find('#edit-phone').val(phone);
            modal.find('#edit-latitude').val(latitude);
            modal.find('#edit-longitude').val(longitude);
            modal.find('#form-edit').attr('action', action);
        });

        // Inisialisasi DataTable
        $(function () {
            $('#table-branches').DataTable({
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
