@extends('layouts.hris')

@section('title', 'Edit Karyawan: ' . $employee->name)
@section('content_header')
    <h1><i class="fas fa-user-edit"></i> Edit Data Karyawan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/portal">Portal</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hris.employees.index') }}">Karyawan</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ada kesalahan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <form action="{{ route('hris.employees.update', $employee) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card card-outline card-warning">
            <div class="card-header">
                <h3 class="card-title">Form Edit Karyawan</h3>
            </div>

            <!-- Progress -->
            <div class="card-body">
                <div class="steps d-flex justify-content-between mb-4">
                    <div class="step text-center flex-fill">
                        <button type="button" class="btn btn-lg btn-circle btn-primary step-btn" data-step="1">1</button>
                        <p>Data Pribadi</p>
                    </div>
                    <div class="step text-center flex-fill">
                        <button type="button" class="btn btn-lg btn-circle btn-secondary step-btn"
                            data-step="2">2</button>
                        <p>Data Pekerjaan</p>
                    </div>
                    <div class="step text-center flex-fill">
                        <button type="button" class="btn btn-lg btn-circle btn-secondary step-btn"
                            data-step="3">3</button>
                        <p>Dokumen & Lainnya</p>
                    </div>
                </div>

                <!-- Step 1: Data Pribadi -->
                <div class="step-content" data-step="1">
                    <h4><i class="fas fa-id-card"></i> Data Pribadi</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIK Karyawan <span class="text-danger">*</span></label>
                                <input type="text" name="employee_number"
                                    value="{{ old('employee_number', $employee->employee_number) }}" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $employee->name) }}"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="gender" class="form-control select2" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L" {{ $employee->gender == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="P" {{ $employee->gender == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="birth_place"
                                    value="{{ old('birth_place', $employee->birth_place) }}" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                {{-- <input type="date" name="birth_date" value="{{ old('birth_date', $employee->birth_date) }}" class="form-control" required> --}}
                                <input type="date" name="birth_date"
                                    value="{{ old('birth_date', \Carbon\Carbon::parse($employee->birth_date)->format('Y-m-d')) }}"
                                    class="form-control" required>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Agama <span class="text-danger">*</span></label>
                                <select name="religion" class="form-control select2" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $religion)
                                        <option value="{{ $religion }}"
                                            {{ $employee->religion == $religion ? 'selected' : '' }}>{{ $religion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Golongan Darah</label>
                                <input type="text" name="blood_type"
                                    value="{{ old('blood_type', $employee->blood_type) }}" class="form-control"
                                    maxlength="3" placeholder="A+, B, AB">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status Perkawinan <span class="text-danger">*</span></label>
                                <select name="marital_status" class="form-control select2" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="belum_menikah"
                                        {{ $employee->marital_status == 'belum_menikah' ? 'selected' : '' }}>Belum Menikah
                                    </option>
                                    <option value="menikah" {{ $employee->marital_status == 'menikah' ? 'selected' : '' }}>
                                        Menikah</option>
                                    <option value="cerai_hidup"
                                        {{ $employee->marital_status == 'cerai_hidup' ? 'selected' : '' }}>Cerai Hidup
                                    </option>
                                    <option value="cerai_mati"
                                        {{ $employee->marital_status == 'cerai_mati' ? 'selected' : '' }}>Cerai Meninggal
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" rows="3" required>{{ old('address', $employee->address) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Pos</label>
                                <input type="text" name="postal_code"
                                    value="{{ old('postal_code', $employee->postal_code) }}" class="form-control"
                                    maxlength="10">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email (Opsional)</label>
                                <input type="email" name="email" value="{{ old('email', $employee->email) }}"
                                    class="form-control">
                                <small class="text-muted">Kosongkan untuk gunakan: NIK@jembatannusantara.co.id</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pendidikan Terakhir</label>
                                <input type="text" name="education_level"
                                    value="{{ old('education_level', $employee->education_level) }}"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jurusan/Prodi</label>
                                <input type="text" name="major" value="{{ old('major', $employee->major) }}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Institusi</label>
                                <input type="text" name="university"
                                    value="{{ old('university', $employee->university) }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Data Pekerjaan -->
                <div class="step-content d-none" data-step="2">
                    <h4><i class="fas fa-briefcase"></i> Data Pekerjaan</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cabang / Kantor / Kapal <span class="text-danger">*</span></label>
                                <select name="branch_id" id="branch_id" class="form-control select2" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}"
                                            {{ $employee->branch_id == $branch->id ? 'selected' : '' }}>
                                            {{ $branch->name }} ({{ ucfirst($branch->type) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Divisi / Departemen <span class="text-danger">*</span></label>
                                <select name="department_id" id="department_id" class="form-control select2" required>
                                    <option value="">-- Pilih Dulu Cabang --</option>
                                    @if ($employee->department)
                                        <option value="{{ $employee->department_id }}" selected>
                                            {{ $employee->department->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unit Kerja</label>
                                <select name="unit_id" id="unit_id" class="form-control select2">
                                    <option value="">-- Pilih Dulu Divisi --</option>
                                    @if ($employee->unit)
                                        <option value="{{ $employee->unit_id }}" selected>{{ $employee->unit->name }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <select name="position_id" id="position_id" class="form-control select2" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($positions as $pos)
                                        <option value="{{ $pos->id }}" data-type="{{ $pos->employee_type }}"
                                            {{ $employee->position_id == $pos->id ? 'selected' : '' }}>
                                            {{ $pos->name }} ({{ $pos->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status Kepegawaian <span class="text-danger">*</span></label>
                                <select name="employment_status" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach (['tetap', 'kontrak', 'magang', 'honor'] as $status)
                                        <option value="{{ $status }}"
                                            {{ $employee->employment_status == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>TMT Kerja <span class="text-danger">*</span></label>
                                <input type="date" name="joining_date"
                                    value="{{ old('joining_date', \Carbon\Carbon::parse($employee->joining_date)->format('Y-m-d')) }}"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row contract-fields {{ $employee->employment_status === 'kontrak' ? '' : 'd-none' }}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Mulai Kontrak</label>
                                <input type="date" name="contract_start"
                                    value="{{ old('contract_start', $employee->contract_start) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Akhir Kontrak</label>
                                <input type="date" name="contract_end"
                                    value="{{ old('contract_end', $employee->contract_end) }}" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Dokumen & Lainnya -->
                <div class="step-content d-none" data-step="3">
                    <h4><i class="fas fa-file-alt"></i> Dokumen & Informasi Tambahan</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIK KTP <span class="text-danger">*</span></label>
                                <input type="text" name="id_card_number"
                                    value="{{ old('id_card_number', $employee->id_card_number) }}" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Kartu Keluarga</label>
                                <input type="text" name="family_card_number"
                                    value="{{ old('family_card_number', $employee->family_card_number) }}"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NPWP</label>
                                <input type="text" name="npwp_number"
                                    value="{{ old('npwp_number', $employee->npwp_number) }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>BPJS Ketenagakerjaan</label>
                                <input type="text" name="bpjs_ketenagakerjaan"
                                    value="{{ old('bpjs_ketenagakerjaan', $employee->bpjs_ketenagakerjaan) }}"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>BPJS Kesehatan</label>
                                <input type="text" name="bpjs_kesehatan"
                                    value="{{ old('bpjs_kesehatan', $employee->bpjs_kesehatan) }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Kontak Darurat <span class="text-danger">*</span></label>
                        <input type="text" name="emergency_contact_name"
                            value="{{ old('emergency_contact_name', $employee->emergency_contact_name) }}"
                            class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hubungan Keluarga <span class="text-danger">*</span></label>
                                <input type="text" name="emergency_contact_relation"
                                    value="{{ old('emergency_contact_relation', $employee->emergency_contact_relation) }}"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon Darurat <span class="text-danger">*</span></label>
                                <input type="text" name="emergency_contact_phone"
                                    value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone) }}"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Catatan Tambahan</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $employee->description) }}</textarea>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="card-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-default" id="prev-btn" disabled>Kembali</button>
                    <button type="button" class="btn btn-primary" id="next-btn">Lanjut</button>
                    <button type="submit" class="btn btn-success d-none" id="submit-btn">Update Karyawan</button>
                </div>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        .btn-circle {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
    </style>
@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            // Inisialisasi select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            let currentStep = 1;

            function showStep(step) {
                $('.step-content').addClass('d-none');
                $(`.step-content[data-step="${step}"]`).removeClass('d-none');

                $('.step-btn').removeClass('btn-primary').addClass('btn-secondary');
                $(`.step-btn[data-step="${step}"]`).removeClass('btn-secondary').addClass('btn-primary');

                $('#prev-btn').prop('disabled', step === 1);
                if (step === 3) {
                    $('#next-btn').addClass('d-none');
                    $('#submit-btn').removeClass('d-none');
                } else {
                    $('#next-btn').removeClass('d-none');
                    $('#submit-btn').addClass('d-none');
                }
            }

            showStep(currentStep);

            $('#next-btn').click(() => {
                if (currentStep < 3) currentStep++;
                showStep(currentStep);
            });
            $('#prev-btn').click(() => {
                if (currentStep > 1) currentStep--;
                showStep(currentStep);
            });

            // Load departments & units via AJAX
            $('#branch_id').change(function() {
                const branchId = $(this).val();
                $('#department_id').html('<option value="">-- Memuat... --</option>').prop('disabled',
                    true);
                $('#unit_id').html('<option value="">-- Pilih Dulu Divisi --</option>');

                if (!branchId) return;

                $.get(`/hris/api/departments?branch_id=${branchId}`, function(data) {
                    $('#department_id').empty().append('<option value="">-- Pilih --</option>');
                    data.forEach(d => {
                        $('#department_id').append(
                            `<option value="${d.id}">${d.name}</option>`);
                    });
                    $('#department_id').prop('disabled', false).trigger('change');
                });
            });

            $('#department_id').change(function() {
                const deptId = $(this).val();
                $('#unit_id').html('<option value="">-- Memuat... --</option>').prop('disabled', true);

                if (!deptId) return;

                $.get(`/hris/api/units?department_id=${deptId}`, function(data) {
                    $('#unit_id').empty().append('<option value="">-- Pilih --</option>');
                    data.forEach(u => {
                        $('#unit_id').append(`<option value="${u.id}">${u.name}</option>`);
                    });
                    $('#unit_id').prop('disabled', false).trigger('change');
                });
            });

            $('select[name="employment_status"]').change(function() {
                if ($(this).val() === 'kontrak') {
                    $('.contract-fields').removeClass('d-none');
                } else {
                    $('.contract-fields').addClass('d-none');
                }
            }).trigger('change');
        });
    </script>
@endpush
