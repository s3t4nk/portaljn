<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $employee->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            font-size: 10pt;
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

        .info-grid {
            display: grid;
            grid-template-columns: 100px 1fr 100px 1fr;
            gap: 8px;
            margin-bottom: 15px;
        }

        .table-container {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .table {
            width: 50%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
            font-size: 10pt;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }

        .take-home-pay {
            text-align: center;
            margin-top: 20px;
            font-size: 12pt;
            font-weight: bold;
            padding: 10px;
            border: 2px solid #000;
            width: 60%;
            margin: 30px auto 0;
        }

        .logo {
            float: left;
            margin-right: 10px;
            max-width: 80px;
        }

        .no-border {
            border: none !important;
        }

        .thin-border {
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-left: 1px solid #ccc;
            border-right: 1px solid #ccc;
        }

        .signature {
            margin-top: 30px;
            text-align: center;
            font-size: 9pt;
            color: #555;
        }

        .barcode {
            display: block;
            margin: 10px auto;
            width: 120px;
            height: 50px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <div class="header">
        @if (file_exists(public_path('images/logo.png')))
            <img src="{{ asset('images/logo.png') }}" alt="Logo Perusahaan" class="logo">
        @endif
        <div class="company-name">{{ $company['name'] }}</div>
    </div>

    <div class="title">RINCIAN PEMBAYARAN PENGHASILAN PEGAWAI</div>

    <!-- Informasi Karyawan -->
    <table class="table no-border" style="width: 100%; border-collapse: separate; border-spacing: 0;">
        <tr>
            <td style="width: 25%; padding: 4px; vertical-align: top;"><strong>Bulan Gaji</strong></td>
            <td style="width: 25%; padding: 4px; vertical-align: top;">:
                {{ \Carbon\Carbon::createFromFormat('Y-m', $history->period)->locale('id')->isoFormat('MMMM YYYY') }}
            </td>
            <td style="width: 25%; padding: 4px; vertical-align: top;"><strong>Unit Kerja</strong></td>
            <td style="width: 25%; padding: 4px; vertical-align: top;">: {{ $employee->unit?->name ?? '-' }}</td>
        </tr>
        <tr>
            <td style="padding: 4px; vertical-align: top;"><strong>Nama Lengkap</strong></td>
            <td style="padding: 4px; vertical-align: top;">: {{ $employee->name }}</td>
            <td style="padding: 4px; vertical-align: top;"><strong>Status Pegawai</strong></td>
            <td style="padding: 4px; vertical-align: top;">: {{ ucfirst($employee->employment_status) }}</td>
        </tr>
        <tr>
            <td style="padding: 4px; vertical-align: top;"><strong>NIK</strong></td>
            <td style="padding: 4px; vertical-align: top;">: {{ $employee->employee_number }}</td>
            <td style="padding: 4px; vertical-align: top;"><strong>Jabatan</strong></td>
            <td style="padding: 4px; vertical-align: top;">: {{ $employee->position?->name ?? '-' }}</td>
        </tr>
    </table>

    <!-- Table: Penerimaan & Potongan -->
<div class="table-container">
    <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
        <thead>
            <tr>
                <!-- Penerimaan -->
                <th style="width: 10%; padding: 6px; text-align: center;">No</th>
                <th style="width: 30%; padding: 6px;">Komponen</th>
                <th style="width: 25%; padding: 6px; text-align: right;">Nominal</th>
                <!-- Spacer -->
                <th style="width: 5%;"></th>
                <!-- Potongan -->
                <th style="width: 10%; padding: 6px; text-align: center;">No</th>
                <th style="width: 30%; padding: 6px;">Komponen</th>
                <th style="width: 25%; padding: 6px; text-align: right;">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <!-- Baris 1: Gaji Pokok & Iuran Pegawai -->
            <tr>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">1</td>
                <td style="border: 1px solid #000; padding: 6px;">Gaji Pokok</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right;">Rp {{ number_format($history->base_salary, 0, ',', '.') }}</td>
                <td style="border: 1px solid #000;"></td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">1</td>
                <td style="border: 1px solid #000; padding: 6px;">Iuran Pegawai</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right;">Rp 234.557</td>
            </tr>

            <!-- Baris 2: Tunjangan Jabatan & BPJS Ketenagakerjaan -->
            <tr>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">2</td>
                <td style="border: 1px solid #000; padding: 6px;">Tunjangan Jabatan</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right;">Rp 1.750.000</td>
                <td style="border: 1px solid #000;"></td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">2</td>
                <td style="border: 1px solid #000; padding: 6px;">BPJS Ketenagakerjaan</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right;">Rp 2.345</td>
            </tr>

            <!-- Baris 3: Tunjangan Mobilitas & Koperasi -->
            <tr>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">3</td>
                <td style="border: 1px solid #000; padding: 6px;">Tunjangan Mobilitas</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right;">Rp 400.000</td>
                <td style="border: 1px solid #000;"></td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">3</td>
                <td style="border: 1px solid #000; padding: 6px;">Koperasi</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right;">Rp 45.678</td>
            </tr>

            <!-- Baris 4: Pinjaman Bank -->
            <tr>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;"></td>
                <td style="border: 1px solid #000; padding: 6px;"></td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right;"></td>
                <td style="border: 1px solid #000;"></td>
                <td style="border: 1px solid #000; padding: 6px; text-align: center;">4</td>
                <td style="border: 1px solid #000; padding: 6px;">Pinjaman Bank</td>
                <td style="border: 1px solid #000; padding: 6px; text-align: right;">Rp 45.678</td>
            </tr>

            <!-- Baris Total -->
            <tr>
                <td colspan="3" style="border: 1px solid #000; padding: 6px; font-weight: bold; background-color: #f2f2f2;">Total Penerimaan</td>
                <td style="border: 1px solid #000;"></td>
                <td colspan="3" style="border: 1px solid #000; padding: 6px; font-weight: bold; background-color: #f2f2f2;">Total Potongan</td>
            </tr>
        </tbody>
    </table>
</div>
    <!-- Take Home Pay -->
    <div class="take-home-pay">
        TAKE HOME PAY<br>
        Rp {{ number_format($history->total_salary - 328258, 0, ',', '.') }}
    </div>

    <!-- Signature with QR Code -->
    <div style="margin-top: 30px; text-align: center; font-size: 9pt;">
        <p><strong>Mengetahui,</strong></p>
        <p><strong>{{ $gm_data['position'] }}</strong></p>
        <img src="{{ $qr_code }}" alt="QR Code" style="width: 100px; height: 100px; margin: 10px auto;">
        <p><small>NIP: {{ $gm_data['nik'] }}</small></p>
    </div>
</body>

</html>
