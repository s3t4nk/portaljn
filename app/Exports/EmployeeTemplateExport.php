<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class EmployeeTemplateExport implements FromCollection, WithHeadings, WithColumnWidths, WithEvents
{
    public function collection()
    {
        return collect([]); // Kosong — hanya untuk header
    }

    public function headings(): array
    {
        return [
            'nik',
            'nik_ktp',
            'nama_lengkap',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'agama',
            'status_pernikahan',
            'email',
            'tipe_karyawan',
            'status_karyawan',
            'tanggal_masuk',
            'tanggal_tetap',
            'resign_date',
            'Alasan Resign',
            'id_cabang',
            'id_jabatan',
            'id_unit',
            'phone',
            'address',
            'emergency_contact_name',
            'emergency_contact_phone',
            'relationship',
            'bank_name',
            'bank_account',
            'bpjs_kesehatan',
            'bpjs_ketenagakerjaan',
            'asuransi_lain',
            'notes'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, 'B' => 15, 'C' => 25, 'D' => 20, 'E' => 15,
            'F' => 15, 'G' => 15, 'H' => 20, 'I' => 30, 'J' => 15,
            'K' => 15, 'L' => 15, 'M' => 15, 'N' => 15, 'O' => 20,
            'P' => 20, 'Q' => 20, 'R' => 20, 'S' => 15, 'T' => 30,
            'U' => 20, 'V' => 15, 'W' => 20, 'X' => 20, 'Y' => 20,
            'Z' => 15, 'AA' => 15, 'AB' => 15, 'AC' => 30,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Dropdown Jenis Kelamin
                $this->addDropdown($sheet, 'F2', ['L', 'P']);

                // Dropdown Agama
                $this->addDropdown($sheet, 'G2', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu']);

                // Dropdown Status Pernikahan
                $this->addDropdown($sheet, 'H2', ['belum_menikah', 'menikah', 'cerai_hidup', 'cerai_mati']);

                // Dropdown Tipe Karyawan
                $this->addDropdown($sheet, 'J2', ['darat', 'laut', 'semua']);

                // Dropdown Status Karyawan
                $this->addDropdown($sheet, 'K2', ['tetap', 'kontrak', 'magang', 'honor']);
            },
        ];
    }

    private function addDropdown($sheet, $cell, $values)
    {
        $validation = new DataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setFormula1('"' . implode(',', $values) . '"');
        $validation->setAllowBlank(false);
        $validation->setShowDropDown(true);
        $sheet->getCell($cell)->setDataValidation($validation);
    }
}