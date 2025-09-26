<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Slip Gaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .header img {
            height: 100px;
            margin-right: 10px;
        }

        .header-text {
            line-height: 1.2;
        }

        .header-text .company-name {
            font-weight: bold;
        }

        .header-text .tagline {
            font-size: 10px;
        }

        < !DOCTYPE html><html><head><meta charset="utf-8"><title>Slip Gaji</title><style>body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .header img {
            height: 80px;
            /* 🔍 DIBESARKAN */
            margin-right: 15px;
        }

        .header-text {
            line-height: 1.2;
        }

        .header-text .company-name {
            font-weight: bold;
            font-size: 14px;
        }

        .header-text .tagline {
            font-size: 10px;
            color: #666;
        }

        /* Garis biru di bawah logo */
        .blue-line {
            width: 100%;
            height: 3px;
            background-color: #007BFF;
            /* Biru solid */
            margin: 5px 0 15px 0;
        }

        .title {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 15px 0;
        }

        .section {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        td,
        th {
            padding: 4px;
            vertical-align: top;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000;
        }

        .text-right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .footer {
            font-size: 10px;
            margin-top: 30px;
            border-top: 1px solid #000;
            padding-top: 5px;
            text-align: center;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    <div class="header">
        @if ($company['logo'])
            <img src="{{ $company['logo'] }}">
        @endif
        {{-- <div class="header-text">
            <div class="company-name">{{ $company['name'] }}</div>
            <div class="tagline">SHIP OWNER OF CAR AND PASSENGER CARRIER</div>
        </div> --}}
    </div>

    <div class="blue-line"></div>

    {{-- Title --}}
    <div class="title">SURAT KETERANGAN PENGHASILAN</div>

    {{-- Data pemberi --}}
    <div class="section">
        Yang bertanda tangan dibawah ini :
        <table>
            <tr>
                <td style="width:120px;">Nama</td>
                <td>: {{ $gm_data['name'] }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>: {{ $gm_data['nik'] }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: {{ $gm_data['position'] }}</td>
            </tr>
            <tr>
                <td>Berkedudukan</td>
                <td>: {{ $gm_data['address'] }}</td>
            </tr>
        </table>
    </div>

    {{-- Data penerima --}}
    {{-- Data penerima --}}
    <div class="section">
        Menerangkan bahwa :
        <table>
            <tr>
                <td style="width:120px;">Nama</td>
                <td>: {{ $employee_name }}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>: {{ $employee_number }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>: {{ $position_name }}</td>
            </tr>
            <tr>
                <td>Divisi</td>
                <td>: {{ $unit_name }}</td>
            </tr>
            <tr>
                <td>Cabang/Kapal</td>
                <td>: {{ $branch_name }}</td>
            </tr>
        </table>
    </div>

    {{-- Tabel rincian gaji --}}
    <div class="section">
        Berdasarkan pembayaran {{ $history->period }} mempunyai penghasilan/gaji dengan rincian sebagai berikut :
        <table class="table-bordered">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th>KETERANGAN</th>
                    <th style="width:180px;" class="text-right">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                {{-- 1. Gaji Pokok --}}
                <tr>
                    <td>1</td>
                    <td>Gaji Pokok</td>
                    <td class="text-right">Rp {{ number_format($history->base_salary ?? 0, 0, ',', '.') }}</td>
                </tr>

                {{-- 2. Tunjangan --}}
                @php $no = 1; @endphp
                @foreach ($allowances as $a)
                    <tr>
                        <td>2.{{ $loop->iteration }}</td>
                        <td>{{ $a['name'] }}</td>
                        <td class="text-right">Rp {{ number_format($a['amount'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                <tr class="bold">
                    <td colspan="2">Jumlah Penghasilan</td>
                    <td class="text-right">Rp {{ number_format($grossIncome, 0, ',', '.') }}</td>
                </tr>

                {{-- 3. Potongan --}}
                @php $no = 1; @endphp
                @foreach ($deductions as $d)
                    <tr>
                        <td>3.{{ $loop->iteration }}</td>
                        <td>{{ $d['name'] }}</td>
                        <td class="text-right">Rp {{ number_format($d['amount'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                <tr class="bold">
                    <td colspan="2">Jumlah Potongan</td>
                    <td class="text-right">Rp {{ number_format($potonganTotal, 0, ',', '.') }}</td>
                </tr>

                <tr class="bold">
                    <td colspan="2">Jumlah Penghasilan Netto</td>
                    <td class="text-right">Rp {{ number_format($netIncome, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Tanda tangan --}}
    <table style="width:100%; margin-top:30px;">
        <tr>
            <td style="text-align:center;">
                Mengetahui,<br>{{ $gm_data['position'] }}<br><br><br><br>
                <b>{{ $gm_data['name'] }}</b><br>
                NIP. {{ $gm_data['nik'] }}
            </td>
            <td style="text-align:center;">
                Surabaya, {{ now()->format('d F Y') }}<br>{{ $creator_data['position'] }}<br><br><br><br>
                <b>{{ $creator_data['name'] }}</b><br>
                NIK. {{ $creator_data['nik'] }}
            </td>
        </tr>
    </table>

    <div class="footer">
        Head Office Surabaya<br>
        Gedung Pleni Heritage Lt.2<br>
        Jl. Pahlawan No.112-114 Surabaya 60175<br>
        Telp. +62 31 9922 0000 (Hunting)
    </div>
</body>

</html>
