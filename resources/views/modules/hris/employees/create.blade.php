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

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Form Registrasi Karyawan</h3>
        </div>

        <form action="{{ route('hris.employees.store') }}" method="POST" id="multi-step-form">
            @csrf

            <!-- Progress -->
            <div class="card-body">
                <div class="steps d-flex justify-content-between mb-4">
                    <div class="step text-center flex-fill">
                        <button type="button" class="btn btn-lg btn-circle btn-primary step-btn" data-step="1">1</button>
                        <p>Data Pribadi</p>
                    </div>
                    <div class="step text-center flex-fill">
                        <button type="button" class="btn btn-lg btn-circle btn-secondary step-btn" data-step="2">2</button>
                        <p>Data Pekerjaan</p>
                    </div>
                    <div class="step text-center flex-fill">
                        <button type="button" class="btn btn-lg btn-circle btn-secondary step-btn" data-step="3">3</button>
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
                                <input type="text" name="employee_number" id="nik_input" class="form-control" required>
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
                                <input type="text" name="blood_type" class="form-control" maxlength="3" placeholder="A, B+, AB-">
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
                                <input type="text" name="postal_pos" class="form-control" maxlength="10" placeholder="misal: 69116">
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pendidikan Terakhir</label>
                                <input type="text" name="education_level" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jurusan/Prodi</label>
                                <input type="text" name="major" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                                <select name="branch_id" class="form-control branch-select" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }} ({{ ucfirst($branch->type) }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Divisi / Departemen <span class="text-danger">*</span></label>
                                <select name="department_id" class="form-control department-select" required>
                                    <option value="">-- Pilih Dulu Cabang --</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Unit Kerja</label>
                                <select name="unit_id" class="form-control unit-select">
                                    <option value="">-- Pilih Dulu Divisi --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <select name="position_id" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($positions as $pos)
                                        <option value="{{ $pos->id }}">{{ $pos->name }} ({{ $pos->code }})</option>
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Bank</label>
                                <input type="text" name="bank_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Rekening</label>
                                <input type="text" name="bank_number" class="form-control">
                            </div>
                        </div>
                    </div>
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

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentStep = 1;

    // Fungsi: Tampilkan step tertentu
    function showStep(step) {
        // Sembunyikan semua step
        document.querySelectorAll('.step-content').forEach(el => {
            el.classList.add('d-none');
        });

        // Tampilkan step aktif
        const target = document.querySelector(`[data-step="${step}"]`);
        if (target) {
            target.classList.remove('d-none');
        }

        // Update tombol navigasi
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        const submitBtn = document.getElementById('submit-btn');

        if (prevBtn) prevBtn.disabled = (step === 1);
        if (nextBtn && submitBtn) {
            if (step === 3) {
                nextBtn.classList.add('d-none');
                submitBtn.classList.remove('d-none');
            } else {
                nextBtn.classList.remove('d-none');
                submitBtn.classList.add('d-none');
            }
        }

        // Update progress button
        document.querySelectorAll('.step-btn').forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-secondary');
        });
        document.querySelector(`.step-btn[data-step="${step}"]`).classList.remove('btn-secondary');
        document.querySelector(`.step-btn[data-step="${step}"]`).classList.add('btn-primary');
    }

    // Inisialisasi
    showStep(currentStep);

    // Tombol Lanjut
    document.getElementById('next-btn')?.addEventListener('click', function () {
        if (currentStep < 3) {
            currentStep++;
            showStep(currentStep);
        }
    });

    // Tombol Kembali
    document.getElementById('prev-btn')?.addEventListener('click', function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    // Navigasi cepat via tombol step
    document.querySelectorAll('.step-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const step = parseInt(this.getAttribute('data-step'));
            if (step <= currentStep) {
                currentStep = step;
                showStep(currentStep);
            }
        });
    });

    // Dynamic Department & Unit
    document.querySelector('.branch-select')?.addEventListener('change', function () {
        const branchId = this.value;
        if (!branchId) return;

        fetch(`/api/departments?branch_id=${branchId}`)
            .then(res => res.json())
            .then(data => {
                const deptSelect = document.querySelector('.department-select');
                deptSelect.innerHTML = '<option value="">-- Pilih --</option>';
                data.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = d.id;
                    opt.textContent = d.name;
                    deptSelect.appendChild(opt);
                });
                document.querySelector('.unit-select').innerHTML = '<option value="">-- Pilih Dulu Divisi --</option>';
            })
            .catch(err => console.error('Gagal muat departemen:', err));
    });

    document.querySelector('.department-select')?.addEventListener('change', function () {
        const deptId = this.value;
        if (!deptId) return;

        fetch(`/api/units?department_id=${deptId}`)
            .then(res => res.json())
            .then(data => {
                const unitSelect = document.querySelector('.unit-select');
                unitSelect.innerHTML = '<option value="">-- Pilih --</option>';
                data.forEach(u => {
                    const opt = document.createElement('option');
                    opt.value = u.id;
                    opt.textContent = u.name;
                    unitSelect.appendChild(opt);
                });
            })
            .catch(err => console.error('Gagal muat unit:', err));
    });

    // Show/hide kontrak fields
    document.querySelector('select[name="employment_status"]')?.addEventListener('change', function () {
        const contractFields = document.querySelector('.contract-fields');
        if (this.value === 'kontrak') {
            contractFields?.classList.remove('d-none');
        } else {
            contractFields?.classList.add('d-none');
        }
    });

    // Auto-generate Email Preview
    const nikInput = document.getElementById('nik_input');
    const emailPreview = document.getElementById('auto-email-preview');

    function updateEmailPreview() {
        const nik = nikInput?.value.trim() || '';
        emailPreview.textContent = nik ? `${nik}@jembatannusantara.co.id` : '______@jembatannusantara.co.id';
    }

    if (nikInput && emailPreview) {
        nikInput.addEventListener('input', updateEmailPreview);
        updateEmailPreview(); // Initial call
    }
});
</script>
@endpush