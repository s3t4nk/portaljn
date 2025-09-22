<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\HRIS\Models\Position;
use App\Modules\HRIS\Models\SalaryGrade;
use Illuminate\Support\Facades\Log;

class PositionSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Memulai seeding jabatan...');

        $grades = SalaryGrade::pluck('id', 'code')->toArray();
        $totalInserted = 0;

        $positions = [
            // ========================================================================
            // === KANTOR PUSAT ===
            // ========================================================================

            // DIREKSI
            ['name' => 'DIREKTUR UTAMA', 'code' => 'DIR-UTAMA', 'salary_grade_code' => 'VII-C1', 'type' => 'struktural', 'employee_type' => 'semua', 'is_management' => true, 'description' => 'Pemimpin tertinggi perusahaan'],
            ['name' => 'DIREKTUR KEUANGAN, SDM & MANAJEMEN RISIKO', 'code' => 'DIR-KEU-SDM', 'salary_grade_code' => 'VII-C1', 'type' => 'struktural', 'employee_type' => 'semua', 'is_management' => true, 'description' => 'Menangani keuangan, SDM, dan risiko korporasi'],
            ['name' => 'DIREKTUR KOMERSIAL & TEKNIK', 'code' => 'DIR-KOMTEK', 'salary_grade_code' => 'VII-C1', 'type' => 'struktural', 'employee_type' => 'semua', 'is_management' => true, 'description' => 'Menangani komersial dan operasional teknik'],

            // POSISI PENDUKUNG DIREKSI
            ['name' => 'KEPALA SATUAN PENGAWAS INTERNAL', 'code' => 'KSPI', 'salary_grade_code' => 'VII-C1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Kepala SPI, menangani audit internal'],
            ['name' => 'CORPORATE SECRETARY', 'code' => 'CS', 'salary_grade_code' => 'VII-C1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Sekretaris perusahaan, penanggung jawab hukum & administrasi'],

            // GENERAL MANAGER
            ['name' => 'GENERAL MANAGER KEUANGAN DAN AKUNTANSI', 'code' => 'GM-KEU', 'salary_grade_code' => 'VI-C1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'GM Keuangan & Akuntansi'],
            ['name' => 'GENERAL MANAGER SDM DAN PENDUKUNG BISNIS', 'code' => 'GM-SDM', 'salary_grade_code' => 'VI-C1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'GM SDM & Pendukung Bisnis'],
            ['name' => 'GENERAL MANAGER TEKNIK KAPAL', 'code' => 'GM-TEK', 'salary_grade_code' => 'VI-C1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'GM Teknik Kapal'],
            ['name' => 'GENERAL MANAGER KOMERSIAL DAN OPERASI', 'code' => 'GM-KOM-OPS', 'salary_grade_code' => 'VI-C1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'GM Komersial & Operasi'],
            ['name' => 'GENERAL MANAGER MANAJEMEN RISIKO DAN GCG', 'code' => 'GM-MRG', 'salary_grade_code' => 'VI-C1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'GM Manajemen Risiko & Good Corporate Governance'],

            // MANAGER
            ['name' => 'MANAGER HUKUM & ASURANSI', 'code' => 'MGR-HK-ASR', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Hukum & Asuransi'],
            ['name' => 'MANAGER KESEKRETARIATAN', 'code' => 'MGR-SEKRE', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Kesekretariatan'],
            ['name' => 'MANAGER K2L DAN MUTU / DPA', 'code' => 'MGR-DPA', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer K3L & Mutu'],
            ['name' => 'MANAGER OPERASIONAL & LAYANAN', 'code' => 'MGR-OPS-LYN', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Operasional & Layanan'],
            ['name' => 'MANAGER KOMERSIAL', 'code' => 'MGR-KOM', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Komersial'],
            ['name' => 'MANAGER PERAWATAN RUTIN', 'code' => 'MGR-PER-RUT', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Perawatan Rutin'],
            ['name' => 'MANAGER PERAWATAN TAHUNAN', 'code' => 'MGR-PER-TH', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Perawatan Tahunan'],
            ['name' => 'MANAGER SUMBER DAYA MANUSIA (SDM)', 'code' => 'MGR-SDM', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer SDM'],
            ['name' => 'MANAGER UMUM & LOGISTIK', 'code' => 'MGR-UM-LOG', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Umum & Logistik'],
            ['name' => 'MANAGER PENGADAAN BARANG & JASA', 'code' => 'MGR-PNG-BRG', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Pengadaan Barang & Jasa'],
            ['name' => 'MANAGER KEUANGAN', 'code' => 'MGR-KEU', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Keuangan'],
            ['name' => 'MANAGER AKUTANSI & ASET', 'code' => 'MGR-AKT-AS', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Akuntansi & Aset'],
            ['name' => 'MANAGER TEKNOLOGI INFORMASI', 'code' => 'MGR-TI', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Manajer Teknologi Informasi'],

            // ASISTEN MANAGER
            ['name' => 'ASSISTANT MANAGER HUKUM & ASURANSI', 'code' => 'AM-HK-ASR', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Hukum & Asuransi'],
            ['name' => 'ASSISTANT MANAGER CORPORATE COMMUNICATION', 'code' => 'AM-CPR-COM', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Komunikasi Korporat'],
            ['name' => 'ASSISTANT MANAGER K2L ARMADA', 'code' => 'AM-K2L-ARM', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer K3L Armada'],
            ['name' => 'ASSISTANT MANAGER MUTU', 'code' => 'AM-MUTU', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Mutu'],
            ['name' => 'ASSISTANT MANAGER OPERASIONAL & LAYANAN', 'code' => 'AM-OPR-LYN', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Operasional & Layanan'],
            ['name' => 'ASSISTANT MANAGER KOMERSIAL & KERJASAMA USAHA', 'code' => 'AM-KOM-KU', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Komersial & Kerjasama Usaha'],
            ['name' => 'ASSISTANT MANAGER PENGENDALIAN BBM', 'code' => 'AM-PGL-BBM', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Pengendalian BBM'],
            ['name' => 'ASSISTANT MANAGER PERAWATAN TAHUNAN AREA 1', 'code' => 'AM-PER-TH-1', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Perawatan Tahunan Area 1'],
            ['name' => 'ASSISTANT MANAGER PERAWATAN TAHUNAN AREA 2', 'code' => 'AM-PER-TH-2', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Perawatan Tahunan Area 2'],
            ['name' => 'ASSISTANT MANAGER PERAWATAN RUTIN AREA 1', 'code' => 'AM-PER-RUT-1', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Perawatan Rutin Area 1'],
            ['name' => 'ASSISTANT MANAGER PERAWATAN RUTIN AREA 2', 'code' => 'AM-PER-RUT-2', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Perawatan Rutin Area 2'],
            ['name' => 'ASSISTANT MANAGER ADMINISTRASI (SDM)', 'code' => 'AM-SDM', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Administrasi SDM'],
            ['name' => 'ASSISTANT MANAGER PERENCANAAN & PENGEMBANGAN', 'code' => 'AM-PRC-PGB', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Perencanaan & Pengembangan'],
            ['name' => 'ASSISTANT MANAGER CREW', 'code' => 'AM-CREW', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Crew'],
            ['name' => 'ASSISTANT MANAGER UMUM', 'code' => 'AM-UM', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Umum'],
            ['name' => 'ASSISTANT MANAGER LOGISTIK', 'code' => 'AM-LOG', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Logistik'],
            ['name' => 'ASSISTANT MANAGER PENGADAAN BARANG', 'code' => 'AM-PGD-BRG', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Pengadaan Barang'],
            ['name' => 'ASSISTANT MANAGER PENGADAAN JASA', 'code' => 'AM-PDG-JS', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Pengadaan Jasa'],
            ['name' => 'ASSISTANT MANAGER COUNTERPAYABLE & RECEIVABLE', 'code' => 'AM-CR', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Counterpayable & Receivable'],
            ['name' => 'ASSISTANT MANAGER TREASURY', 'code' => 'AM-TREA', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Treasury'],
            ['name' => 'ASSISTANT MANAGER LAPORAN AKUNTANSI', 'code' => 'AM-LAP-AKT', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Laporan Akuntansi'],
            ['name' => 'ASSISTANT MANAGER ASET', 'code' => 'AM-AST', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Aset'],
            ['name' => 'ASSISTANT MANAGER TEKNOLOGI & INFORMASI', 'code' => 'AM-TI', 'salary_grade_code' => 'V-A1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => true, 'description' => 'Asisten Manajer Teknologi & Informasi'],

            // STAF
            ['name' => 'STAF HUKUM & ASURANSI', 'code' => 'STF-HK-ASR', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF CORPORATE COMMUNICATION', 'code' => 'STF-CPR-COM', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF K2L ARMADA', 'code' => 'STF-K2L-AMD', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF MUTU', 'code' => 'STF-MUTU', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF OPERASIONAL & LAYANAN', 'code' => 'STF-OPR-LYN', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF KOMERSIAL & KERJASAMA USAHA', 'code' => 'STF-KOM-KJS', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF PENGENDALIAN BBM', 'code' => 'STF-PGDL-BBM', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF PERAWATAN TAHUNAN AREA 1', 'code' => 'STF-PER-TH-1', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF PERAWATAN TAHUNAN AREA 2', 'code' => 'STF-PER-TH-2', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF PERAWATAN RUTIN AREA 1', 'code' => 'STF-PER-RUT-1', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF PERAWATAN RUTIN AREA 2', 'code' => 'STF-PER-RUT-2', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF ADMINISTRASI (SDM)', 'code' => 'STF-ADM', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF PERENCANAAN & PENGEMBANGAN', 'code' => 'STF-PRC-PGB', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF CREW', 'code' => 'STF-CREW', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF UMUM', 'code' => 'STF-UM', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF LOGISTIK', 'code' => 'STF-LOG', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF PENGADAAN BARANG', 'code' => 'STF-PGD-BRG', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF PENGADAAN JASA', 'code' => 'STF-PGD-JS', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF COUNTERPAYABLE & RECEIVABLE', 'code' => 'STF-CR', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF TREASURY', 'code' => 'STF-TSR', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF LAPORAN AKUNTANSI', 'code' => 'STF-AKT', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF ASET', 'code' => 'STF-AST', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF TEKNOLOGI & INFORMASI', 'code' => 'STF-TI', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],

            // ========================================================================
            // === CABANG KELAS A/B/C ===
            // ========================================================================
            ['name' => 'BRANCH MANAGER KELAS A', 'code' => 'BM-A', 'salary_grade_code' => 'VI-C1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true],
            ['name' => 'BRANCH MANAGER KELAS B', 'code' => 'BM-B', 'salary_grade_code' => 'VI-A1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true],
            ['name' => 'BRANCH MANAGER KELAS C', 'code' => 'BM-C', 'salary_grade_code' => 'V-B1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true],
            ['name' => 'ASSISTANT BRANCH MANAGER', 'code' => 'ABM', 'salary_grade_code' => 'V-B1', 'type' => 'struktural', 'employee_type' => 'darat', 'is_management' => true],
            ['name' => 'KASIR KANTOR PUSAT', 'code' => 'KSR-PST', 'salary_grade_code' => 'III-C3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'KASIR KELAS A', 'code' => 'KSR-A', 'salary_grade_code' => 'III-C3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'KASIR KELAS B', 'code' => 'KSR-B', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'KASIR KELAS C', 'code' => 'KSR-C', 'salary_grade_code' => 'III-B1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF CABANG KELAS A', 'code' => 'STF-CAB-A', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF CABANG KELAS B', 'code' => 'STF-CAB-B', 'salary_grade_code' => 'III-B2', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF CABANG KELAS C', 'code' => 'STF-CAB-C', 'salary_grade_code' => 'III-B1', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],
            ['name' => 'STAF OPS. LAPANGAN', 'code' => 'STF-OPS-LAP', 'salary_grade_code' => 'III-B3', 'type' => 'fungsional', 'employee_type' => 'darat', 'is_management' => false],

            // ========================================================================
            // === KAPAL (OPERASIONAL LAUT) ===
            // ========================================================================
            ['name' => 'NAKHODA', 'code' => 'NAKHODA', 'salary_grade_code' => 'VI-C1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => true, 'required_certifications' => json_encode(['STCW', 'BST', 'PSCRB'])],
            ['name' => 'MUALIM I', 'code' => 'MUALIM-I', 'salary_grade_code' => 'V-B1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => false, 'required_certifications' => json_encode(['STCW', 'BST'])],
            ['name' => 'MUALIM II', 'code' => 'MUALIM-II', 'salary_grade_code' => 'V-A1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => false, 'required_certifications' => json_encode(['STCW', 'BST'])],
            ['name' => 'MUALIM III', 'code' => 'MUALIM-III', 'salary_grade_code' => 'IV-C1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => false],
            ['name' => 'MUALIM IV', 'code' => 'MUALIM-IV', 'salary_grade_code' => 'IV-B1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => false],
            ['name' => 'MASINIS I', 'code' => 'MASINIS-I', 'salary_grade_code' => 'V-B1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => false, 'required_certifications' => json_encode(['STCW', 'BST'])],
            ['name' => 'MASINIS II', 'code' => 'MASINIS-II', 'salary_grade_code' => 'V-A1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => false],
            ['name' => 'MASINIS III', 'code' => 'MASINIS-III', 'salary_grade_code' => 'IV-C1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => false],
            ['name' => 'MASINIS IV', 'code' => 'MASINIS-IV', 'salary_grade_code' => 'IV-B1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => false],
            ['name' => 'KOKI', 'code' => 'KOKI', 'salary_grade_code' => 'II-A1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => false],
            ['name' => 'KELASI', 'code' => 'KELASI', 'salary_grade_code' => 'I-D1', 'type' => 'operasional', 'employee_type' => 'laut', 'is_management' => false],
        ];

        foreach ($positions as $pos) {
            $gradeId = $grades[$pos['salary_grade_code']] ?? null;

            if (!$gradeId) {
                Log::warning("Salary grade {$pos['salary_grade_code']} tidak ditemukan untuk posisi: {$pos['name']}");
                continue;
            }

            $position = Position::firstOrCreate(
                ['name' => $pos['name']],
                [
                    'code' => $pos['code'],
                    'salary_grade_id' => $gradeId,
                    'type' => $pos['type'],
                    'employee_type' => $pos['employee_type'],
                    'min_experience_years' => $pos['min_experience_years'] ?? 0,
                    'required_certifications' => $pos['required_certifications'] ?? null,
                    'description' => $pos['description'] ?? null,
                    'is_management' => $pos['is_management']
                ]
            );

            if ($position->wasRecentlyCreated) {
                $totalInserted++;
            }
        }

        $this->command->info("✅ Seeding selesai! {$totalInserted} jabatan baru ditambahkan.");
    }
}