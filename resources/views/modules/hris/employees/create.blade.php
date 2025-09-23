@extends('layouts.hris')

@section('title', 'Tambah Karyawan Baru')
@section('content_header')
    <h1><i class="fas fa-user-plus"></i> Tambah Karyawan Baru</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/portal">Portal</a></li>
            <li class="breadcrumb-item"><a href="{{ route('hris.employees.index') }}">Karyawan</a></li>
            <li class="breadcrumb-item active">Tambah Baru</li>
        </ol>
    </nav>
@stop

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Registrasi Karyawan</h3>
        </div>
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
        <form action="{{ route('hris.employees.store') }}" method="POST" id="multi-step-form" enctype="multipart/form-data">
            @csrf

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
                                <input type="text" name="employee_number" class="form-control" required>
                                <small class="text-success">
                                    Email akan dibuat otomatis:
                                    <strong id="auto-email-preview">______@jembatannusantara.co.id</strong>
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Foto Profil (Opsional)</label>
                                <div class="custom-file">
                                    <input type="file" name="photo" class="custom-file-input" id="photoInput"
                                        accept="image/*">
                                    <label class="custom-file-label" for="photoInput">Pilih file gambar...</label>
                                </div>
                                <small class="form-text text-muted">Format: JPG, PNG. Maks: 2MB.</small>
                                <!-- Preview Container -->
                                <div class="mt-2">
                                    <img id="photoPreview" src="" alt="Preview Foto" class="img-thumbnail d-none"
                                        style="max-height: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="gender" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="birth_place" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="birth_date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Agama <span class="text-danger">*</span></label>
                                <select name="religion" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Khonghucu">Khonghucu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Golongan Darah</label>
                                <input type="text" name="blood_type" class="form-control" maxlength="3"
                                    placeholder="A, B+, AB-">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status Perkawinan <span class="text-danger">*</span></label>
                                <select name="marital_status" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="belum_menikah">Belum Menikah</option>
                                    <option value="menikah">Menikah</option>
                                    <option value="cerai_hidup">Cerai Hidup</option>
                                    <option value="cerai_mati">Cerai Meninggal</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Pos</label>
                                <input type="text" name="postal_code" class="form-control" maxlength="10"
                                    placeholder="misal: 69116">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pendidikan Terakhir</label>
                                <input type="text" name="education_level" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jurusan/Prodi</label>
                                <input type="text" name="major" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Institusi</label>
                                <input type="text" name="university" class="form-control">
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
                                <select name="branch_id" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}
                                            ({{ ucfirst($branch->type) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Divisi / Departemen <span class="text-danger">*</span></label>
                                <select name="department_id" class="form-control" required>
                                    <option value="">-- Pilih Dulu Cabang --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unit Kerja</label>
                                <select name="unit_id" class="form-control">
                                    <option value="">-- Pilih Dulu Divisi --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <select name="position_id" id="position_id" class="form-control select2" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($positions as $pos)
                                        <option value="{{ $pos->id }}" data-type="{{ $pos->employee_type }}">
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
                                    <option value="tetap">Tetap</option>
                                    <option value="kontrak">Kontrak</option>
                                    <option value="magang">Magang</option>
                                    <option value="honor">Honor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>TMT Kerja <span class="text-danger">*</span></label>
                                <input type="date" name="joining_date" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row contract-fields d-none">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Mulai Kontrak</label>
                                <input type="date" name="contract_start" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Akhir Kontrak</label>
                                <input type="date" name="contract_end" class="form-control">
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
                                <input type="text" name="id_card_number" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Kartu Keluarga</label>
                                <input type="text" name="family_card_number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NPWP</label>
                                <input type="text" name="npwp_number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>BPJS Ketenagakerjaan</label>
                                <input type="text" name="bpjs_ketenagakerjaan" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>BPJS Kesehatan</label>
                                <input type="text" name="bpjs_kesehatan" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- 👇👇👇 PENAMBAHAN BARU: BANK & REKENING 👇👇👇 -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-university"></i> Nama Bank</label>
                                <select name="bank_name" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option value="BCA">BCA</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="BNI">BNI</option>
                                    <option value="BRI">BRI</option>
                                    <option value="CIMB Niaga">CIMB Niaga</option>
                                    <option value="Danamon">Danamon</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fas fa-credit-card"></i> Nomor Rekening</label>
                                <input type="number" name="bank_account_number" class="form-control"
                                    placeholder="Contoh: 1234567890">
                            </div>
                        </div>
                    </div>
                    <!-- 👆👆👆 PENAMBAHAN SELESAI 👆👆👆 -->
                    <div class="form-group">
                        <label>Nama Kontak Darurat <span class="text-danger">*</span></label>
                        <input type="text" name="emergency_contact_name" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hubungan Keluarga <span class="text-danger">*</span></label>
                                <input type="text" name="emergency_contact_relation" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Telepon Darurat <span class="text-danger">*</span></label>
                                <input type="text" name="emergency_contact_phone" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Catatan Tambahan</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="card-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-default" id="prev-btn" disabled>Kembali</button>
                    <button type="button" class="btn btn-primary" id="next-btn">Lanjut</button>
                    <button type="submit" class="btn btn-success d-none" id="submit-btn">Simpan Karyawan</button>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-selection {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            height: calc(2.25em + 0.75rem + 2px);
            padding: 0.375rem 0.75rem;
        }

        .form-group.error input,
        .form-group.error select,
        .form-group.error textarea {
            border-color: #dc3545 !important;
            background-color: #f8d7da !important;
        }
    </style>
@stop

@push('js')
    <script>
        $(document).ready(function() {
            console.log('✅ Multi-step script loaded and ready.');

            let currentStep = 1;
            const totalSteps = 3;

            // Inisialisasi Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih --',
                allowClear: true
            });

            // Fungsi tampilkan step
            function showStep(step) {
                $('.step-content').addClass('d-none');
                $(`.step-content[data-step="${step}"]`).removeClass('d-none');
                $('.step-btn').removeClass('btn-primary').addClass('btn-secondary');
                $(`.step-btn[data-step="${step}"]`).removeClass('btn-secondary').addClass('btn-primary');
                $('#prev-btn').prop('disabled', step === 1);
                if (step === totalSteps) {
                    $('#next-btn').addClass('d-none');
                    $('#submit-btn').removeClass('d-none');
                } else {
                    $('#next-btn').removeClass('d-none');
                    $('#submit-btn').addClass('d-none');
                }
            }

            // Tampilkan step awal
            showStep(currentStep);

            // Validasi field wajib per step
            function validateStep(step) {
                let isValid = true;
                let errorMessage = '';

                // Reset error class
                $('.form-group').removeClass('error');

                if (step === 1) {
                    const requiredFields = [{
                            name: 'employee_number',
                            label: 'NIK Karyawan'
                        },
                        {
                            name: 'name',
                            label: 'Nama Lengkap'
                        },
                        {
                            name: 'gender',
                            label: 'Jenis Kelamin'
                        },
                        {
                            name: 'birth_place',
                            label: 'Tempat Lahir'
                        },
                        {
                            name: 'birth_date',
                            label: 'Tanggal Lahir'
                        },
                        {
                            name: 'religion',
                            label: 'Agama'
                        },
                        {
                            name: 'marital_status',
                            label: 'Status Perkawinan'
                        },
                        {
                            name: 'address',
                            label: 'Alamat Lengkap'
                        },
                        {
                            name: 'phone',
                            label: 'No. Telepon'
                        }
                    ];

                    requiredFields.forEach(field => {
                        const input = $(`[name="${field.name}"]`);
                        const value = input.val();
                        if (!value || value.trim() === '') {
                            isValid = false;
                            errorMessage += `• ${field.label} wajib diisi\n`;
                            input.closest('.form-group').addClass('error');
                        }
                    });
                }

                if (step === 2) {
                    const requiredFields = [{
                            name: 'branch_id',
                            label: 'Cabang'
                        },
                        {
                            name: 'department_id',
                            label: 'Departemen'
                        },
                        {
                            name: 'position_id',
                            label: 'Jabatan'
                        },
                        {
                            name: 'employment_status',
                            label: 'Status Kepegawaian'
                        },
                        {
                            name: 'joining_date',
                            label: 'TMT Kerja'
                        }
                    ];

                    requiredFields.forEach(field => {
                        const input = $(`[name="${field.name}"]`);
                        const value = input.val();
                        if (!value || value.trim() === '') {
                            isValid = false;
                            errorMessage += `• ${field.label} wajib diisi\n`;
                            input.closest('.form-group').addClass('error');
                        }
                    });

                    // Validasi kontrak jika dipilih
                    if ($('select[name="employment_status"]').val() === 'kontrak') {
                        const start = $('input[name="contract_start"]').val();
                        const end = $('input[name="contract_end"]').val();
                        if (!start) {
                            isValid = false;
                            errorMessage += '• Tanggal Mulai Kontrak wajib diisi\n';
                            $('input[name="contract_start"]').closest('.form-group').addClass('error');
                        }
                        if (!end) {
                            isValid = false;
                            errorMessage += '• Tanggal Akhir Kontrak wajib diisi\n';
                            $('input[name="contract_end"]').closest('.form-group').addClass('error');
                        }
                    }
                }

                if (step === 3) {
                    const requiredFields = [{
                            name: 'id_card_number',
                            label: 'NIK KTP'
                        },
                        {
                            name: 'emergency_contact_name',
                            label: 'Nama Kontak Darurat'
                        },
                        {
                            name: 'emergency_contact_relation',
                            label: 'Hubungan Keluarga'
                        },
                        {
                            name: 'emergency_contact_phone',
                            label: 'No. Telepon Darurat'
                        }
                    ];

                    requiredFields.forEach(field => {
                        const input = $(`[name="${field.name}"]`);
                        const value = input.val();
                        if (!value || value.trim() === '') {
                            isValid = false;
                            errorMessage += `• ${field.label} wajib diisi\n`;
                            input.closest('.form-group').addClass('error');
                        }
                    });
                }

                if (!isValid) {
                    alert('⚠️ Mohon lengkapi data berikut:\n\n' + errorMessage);
                }

                return isValid;
            }

            // Event: Tombol Lanjut
            $(document).on('click', '#next-btn', function() {
                console.log('➡️ Next button clicked, current step:', currentStep);

                // Validasi step saat ini
                if (!validateStep(currentStep)) {
                    return false;
                }

                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            // Event: Tombol Kembali
            $(document).on('click', '#prev-btn', function() {
                console.log('⬅️ Prev button clicked, current step:', currentStep);
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // Event: Tombol Step (lingkaran)
            $(document).on('click', '.step-btn', function() {
                const step = parseInt($(this).data('step'));
                if (step <= currentStep) {
                    currentStep = step;
                    showStep(currentStep);
                }
            });

            // Dynamic: Cabang → Departemen
            $(document).on('change', 'select[name="branch_id"]', function() {
                const branchId = $(this).val();
                if (!branchId) {
                    $('select[name="department_id"]').html('<option value="">-- Pilih --</option>');
                    $('select[name="unit_id"]').html('<option value="">-- Pilih Dulu Divisi --</option>');
                    return;
                }
                $.get(`/api/departments?branch_id=${branchId}`)
                    .done(function(data) {
                        console.log('✅ Departemen diterima:', data);
                        $('select[name="department_id"]').html('<option value="">-- Pilih --</option>');
                        data.forEach(d => {
                            $('select[name="department_id"]').append(
                                `<option value="${d.id}">${d.name}</option>`
                            );
                        });
                        $('select[name="unit_id"]').html(
                            '<option value="">-- Pilih Dulu Divisi --</option>');
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.error('❌ Gagal memuat departemen:', textStatus, errorThrown);
                        alert('Gagal memuat data departemen. Cek konsol untuk detail error.');
                    });
            });

            // Dynamic: Departemen → Unit
            $(document).on('change', 'select[name="department_id"]', function() {
                const deptId = $(this).val();
                if (!deptId) {
                    $('select[name="unit_id"]').html('<option value="">-- Pilih --</option>');
                    return;
                }
                $.get(`/api/units?department_id=${deptId}`)
                    .done(function(data) {
                        console.log('✅ Unit diterima:', data);
                        $('select[name="unit_id"]').html('<option value="">-- Pilih --</option>');
                        data.forEach(u => {
                            $('select[name="unit_id"]').append(
                                `<option value="${u.id}">${u.name}</option>`
                            );
                        });
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.error('❌ Gagal memuat unit:', textStatus, errorThrown);
                        alert('Gagal memuat data unit. Cek konsol untuk detail error.');
                    });
            });

            // Show/hide field kontrak
            $(document).on('change', 'select[name="employment_status"]', function() {
                if ($(this).val() === 'kontrak') {
                    $('.contract-fields').removeClass('d-none');
                } else {
                    $('.contract-fields').addClass('d-none');
                }
            });

            // Auto-fill email dari NIK
            $(document).on('blur', 'input[name="employee_number"]', function() {
                const nik = $(this).val();
                if (nik && !$('input[name="email"]').length) {
                    // Jika field email tidak ada, update preview saja
                    const email = nik + '@jembatannusantara.co.id';
                    $('#auto-email-preview').text(email);
                } else if (nik && !$('input[name="email"]').val()) {
                    const email = nik + '@jembatannusantara.co.id';
                    $('input[name="email"]').val(email);
                }
            });

            // Preview foto saat dipilih
            $('#photoInput').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#photoPreview')
                            .attr('src', e.target.result)
                            .removeClass('d-none');
                    }
                    reader.readAsDataURL(file);
                    // Update label
                    $(this).next('.custom-file-label').text(file.name);
                } else {
                    $('#photoPreview').addClass('d-none');
                    $(this).next('.custom-file-label').text('Pilih file gambar...');
                }
            });

            // Email Preview (jQuery version)
            const nikInput = $('input[name="employee_number"]');
            const emailPreview = $('#auto-email-preview');

            function updateEmailPreview() {
                const nik = nikInput.val().trim();
                if (nik) {
                    emailPreview.text(`${nik}@jembatannusantara.co.id`);
                } else {
                    emailPreview.text('______@jembatannusantara.co.id');
                }
            }

            updateEmailPreview(); // Saat halaman load
            nikInput.on('input', updateEmailPreview); // Saat user ketik

            // Reset error saat user isi field
            $(document).on('input change', 'input, select, textarea', function() {
                $(this).closest('.form-group').removeClass('error');
            });
        });
    </script>
@endpush
