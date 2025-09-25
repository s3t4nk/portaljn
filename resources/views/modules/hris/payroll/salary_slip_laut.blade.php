<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .header img { height: 60px; margin-right: 10px; }
        .header-text {
            line-height: 1.2;
        }
        .header-text .company-name {
            font-weight: bold;
        }
        .header-text .tagline {
            font-size: 10px;
        }
        .title { text-align:center; font-weight:bold; text-decoration:underline; margin:15px 0; }
        .section { margin:10px 0; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        td, th { padding:4px; vertical-align:top; }
        .table-bordered th, .table-bordered td { border:1px solid #000; }
        .text-right { text-align:right; }
        .bold { font-weight:bold; }
        .sign { text-align:center; margin-top:50px; }
        .footer { font-size:10px; margin-top:30px; border-top:1px solid #000; padding-top:5px; text-align:center; }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        @if($company['logo'])
            <img src="{{ $company['logo'] }}">
        @endif
        {{-- <div class="header-text">
            <div class="company-name">{{ $company['name'] }}</div>
            <div class="tagline">SHIP OWNER OF CAR AND PASSENGER CARRIER</div>
        </div> --}}
    </div>

    <div class="title">SURAT KETERANGAN PENGHASILAN</div>

    {{-- Data pemberi --}}
    <div class="section">
        Yang bertanda tangan dibawah ini :
        <table>
            <tr><td style="width:120px;">Nama</td><td>: {{ $gm_data['name'] }}</td></tr>
            <tr><td>NIP</td><td>: {{ $gm_data['nik'] }}</td></tr>
            <tr><td>Jabatan</td><td>: {{ $gm_data['position'] }}</td></tr>
            <tr><td>Berkedudukan</td><td>: {{ $gm_data['address'] }}</td></tr>
        </table>
    </div>

    {{-- Data penerima --}}
    <div class="section">
        Menerangkan bahwa :
        <table>
            <tr><td style="width:120px;">Nama</td><td>: {{ $employee->name }}</td></tr>
            <tr><td>NIP</td><td>: {{ $employee->employee_number }}</td></tr>
            <tr><td>Jabatan</td><td>: {{ $employee->position->name ?? '-' }}</td></tr>
            <tr><td>Divisi</td><td>: {{ $employee->unit->name ?? '-' }}</td></tr>
            <tr><td>Cabang</td><td>: PT. JEMBATAN NUSANTARA PUSAT</td></tr>
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
                    <td class="text-right">Rp {{ number_format($history->basic_salary,0,',','.') }}</td>
                </tr>

                {{-- 2. Tunjangan --}}
                <tr>
                    <td>2</td>
                    <td>Tunjangan Lainnya</td>
                    <td></td>
                </tr>
                @php $no = 1; @endphp
                @foreach($allowances as $a)
                    <tr>
                        <td>2.{{ $no++ }}</td>
                        <td>{{ $a->name }}</td>
                        <td class="text-right">
                            Rp {{ number_format($a->pivot->amount ?? 0,0,',','.') }}
                            @if(($a->pivot->amount ?? 0) > 0) (+) @endif
                        </td>
                    </tr>
                @endforeach

                <tr class="bold">
                    <td colspan="2">Jumlah Penghasilan</td>
                    <td class="text-right">Rp {{ number_format($grossIncome,0,',','.') }}</td>
                </tr>

                {{-- 3. Potongan --}}
                <tr>
                    <td>3</td>
                    <td>Potongan - potongan</td>
                    <td></td>
                </tr>
                @php $no = 1; @endphp
                @foreach($deductions as $d)
                    <tr>
                        <td>3.{{ $no++ }}</td>
                        <td>{{ $d->name }}</td>
                        <td class="text-right">
                            Rp {{ number_format($d->pivot->amount ?? 0,0,',','.') }}
                            @if(($d->pivot->amount ?? 0) > 0) (-) @endif
                        </td>
                    </tr>
                @endforeach

                <tr class="bold">
                    <td colspan="2">Jumlah Potongan</td>
                    <td class="text-right">Rp {{ number_format($potonganTotal,0,',','.') }}</td>
                </tr>

                <tr class="bold">
                    <td colspan="2">Jumlah Penghasilan Netto</td>
                    <td class="text-right">Rp {{ number_format($netIncome,0,',','.') }}</td>
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
