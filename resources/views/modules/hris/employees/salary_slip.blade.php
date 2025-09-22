<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $employee->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 9pt;
            line-height: 1.2;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
        }

        .title {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin: 10px 0;
        }

        .info-grid td {
            padding: 4px;
            vertical-align: top;
        }

        table.main-table th,
        table.main-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            font-size: 9pt;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .take-home-pay {
            font-weight: bold;
            font-size: 12pt;
            text-align: center;
            padding: 10px;
            border: 2px solid #000;
            width: 60%;
            margin: 20px auto 0;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
            font-size: 9pt;
        }

        .logo {
            float: left;
            max-width: 80px;
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header" style="position: relative; margin-bottom: 40px;">
        @if ($company['logo'])
            <img src="{{ $company['logo'] }}" alt="Logo Perusahaan"
                style="position: absolute; top: 0; left: 0; max-width: 80px; max-height: 80px; z-index: 100;">
        @endif
        <div style="margin-left: 90px;"> <!-- Memberi ruang agar teks tidak tertimpa -->
            <div class="company-name">{{ $company['name'] }}</div>
        </div>
    </div>

    <div class="title">RINCIAN PEMBAYARAN PENGHASILAN PEGAWAI</div>

    <!-- Informasi Karyawan -->
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 15%"><strong>Bulan Gaji</strong></td>
            <td style="width: 25%">:
                {{ \Carbon\Carbon::createFromFormat('Y-m', $history->period)->locale('id')->isoFormat('MMMM YYYY') }}
            </td>
            <td style="width: 5%"></td>
            <td style="width: 15%"><strong>Unit Kerja</strong></td>
            <td style="width: 40%">: {{ $employee->unit?->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Nama Lengkap</strong></td>
            <td>: {{ $employee->name }}</td>
            <td></td>
            <td><strong>Status Pegawai</strong></td>
            <td>: {{ ucfirst($employee->employment_status) }}</td>
        </tr>
        <tr>
            <td><strong>NIK</strong></td>
            <td>: {{ $employee->employee_number }}</td>
            <td></td>
            <td><strong>Jabatan</strong></td>
            <td>: {{ $employee->position?->name ?? '-' }}</td>
        </tr>
    </table>

    <!-- Tabel 7 Kolom -->
    <table class="main-table" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr>
                <th style="width: 10%">No</th>
                <th style="width: 30%">Komponen</th>
                <th style="width: 15%">Nominal</th>
                <th style="width: 5%"></th>
                <th style="width: 10%">No</th>
                <th style="width: 30%">Komponen</th>
                <th style="width: 15%">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <!-- Baris 1 -->
            <tr>
                <td>1</td>
                <td>Gaji Pokok</td>
                <td>Rp {{ number_format($history->base_salary, 0, ',', '.') }}</td>
                <td></td>
                <td>1</td>
                <td>Iuran Pegawai</td>
                <td>Rp 234.557</td>
            </tr>
            <!-- Baris 2 -->
            <tr>
                <td>2</td>
                <td>Tunjangan Jabatan</td>
                <td>Rp 1.750.000</td>
                <td></td>
                <td>2</td>
                <td>BPJS Ketenagakerjaan</td>
                <td>Rp 2.345</td>
            </tr>
            <!-- Baris 3 -->
            <tr>
                <td>3</td>
                <td>Tunjangan Mobilitas</td>
                <td>Rp 400.000</td>
                <td></td>
                <td>3</td>
                <td>Koperasi</td>
                <td>Rp 45.678</td>
            </tr>
            <!-- Baris 4 -->
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>4</td>
                <td>Pinjaman Bank</td>
                <td>Rp 45.678</td>
            </tr>
            <!-- Total -->
            <tr class="total-row">
                <td colspan="2">Total Penerimaan</td>
                <td>Rp {{ number_format($history->total_salary, 0, ',', '.') }}</td>
                <td></td>
                <td colspan="2">Total Potongan</td>
                <td>Rp 328.258</td>
            </tr>
        </tbody>
    </table>

    <!-- Take Home Pay -->
    <div class="take-home-pay">
        TAKE HOME PAY<br>
        Rp {{ number_format($history->total_salary - 328258, 0, ',', '.') }}
    </div>

    <!-- Tanda Tangan -->
    <div class="signature">
        <p><strong>Mengetahui,</strong></p>
        <p><strong>General Manager SDM & Pengembangan Bisnis</strong></p>
        <img src="{{ $qr_code }}" alt="QR Code" style="width: 100px; height: 100px; display: inline-block;">
        <p><small>NIP: {{ $gm_data['nik'] }}</small></p>
    </div>

</body>

</html>
