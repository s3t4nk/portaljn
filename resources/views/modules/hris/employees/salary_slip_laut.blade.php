<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji Laut - {{ $employee->employee_number }} - {{ $history->period }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .container { width: 100%; max-width: 100%; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-width: 200px; }
        .info { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .footer { text-align: right; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if($company['logo'])
                <img src="{{ $company['logo'] }}" alt="Logo {{ $company['name'] }}">
            @endif
            <h2>SURAT KETERANGAN PENGHASILAN</h2>
            <p>Yang bertanda tangan dibawah ini:</p>
            <p><strong>Nama:</strong> {{ $gm_data['name'] }}</p>
            <p><strong>NIP:</strong> {{ $gm_data['nik'] }}</p>
            <p><strong>Jabatan:</strong> {{ $gm_data['position'] }}</p>
            <p><strong>Berkedudukan:</strong> JI. Pahlawan No. 112-114 Surabaya</p>
        </div>

        <div class="info">
            <p>Menerangkan bahwa:</p>
            <p><strong>Nama:</strong> {{ $employee->name }}</p>
            <p><strong>NIP:</strong> {{ $employee->employee_number }}</p>
            <p><strong>Jabatan:</strong> {{ $employee->position?->name ?? '-' }}</p>
            <p><strong>Unit Kerja:</strong> {{ $employee->unit?->name ?? '-' }}</p>
            <p><strong>Cabang:</strong> {{ $employee->branch?->name ?? '-' }}</p>
            <p>Berdasarkan pembayaran periode Bulan {{ \Carbon\Carbon::parse($history->period)->locale('id')->format('F Y') }} mempunyai penghasilan/gaji dengan rincian sebagai berikut:</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Gaji Pokok</td>
                    <td>Rp {{ number_format($history->base_salary, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Tunjangan Lainnya</td>
                    <td></td>
                </tr>
                @foreach ($employee->salaryComponents as $component)
                    <tr>
                        <td></td>
                        <td>{{ $component->name }}</td>
                        <td>Rp {{ number_format($component->pivot->amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td><strong>Jumlah Penghasilan</strong></td>
                    <td><strong>Rp {{ number_format($history->total_salary, 0, ',', '.') }}</strong></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Potongan-potongan:</td>
                    <td></td>
                </tr>
                <!-- Potongan BPJS -->
                <tr>
                    <td></td>
                    <td>BPJS Tenaga Kerja (JHT, JKK, JKM)</td>
                    <td>Rp 99.235</td>
                </tr>
                <tr>
                    <td></td>
                    <td>BPJS Tenaga Kerja (Pensiun)</td>
                    <td>Rp 49.618</td>
                </tr>
                <tr>
                    <td></td>
                    <td>BPJS Kesehatan</td>
                    <td>Rp 49.618</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Lain-lain</td>
                    <td>Rp 1.000</td>
                </tr>
                <tr>
                    <td></td>
                    <td><strong>Jumlah Potongan</strong></td>
                    <td><strong>Rp 199.470</strong></td>
                </tr>
                <tr>
                    <td></td>
                    <td><strong>Jumlah Penghasilan Netto</strong></td>
                    <td><strong>Rp {{ number_format($history->total_salary - 199470, 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Mengetahui,</p>
            <p>Surabaya, {{ now()->format('d M Y') }}</p>
            <p>MANAGER SDM</p>
            <p>{{ $gm_data['name'] }}</p>
            <p>Head Office Surabaya Gedung Pelni Heritage Lt.2</p>
            <p>Jl. Pahlawan No. 112-114 Surabaya 60175</p>
            <p>Telp. +62 31 9922 0000 (Hunting)</p>
        </div>
    </div>
</body>
</html>