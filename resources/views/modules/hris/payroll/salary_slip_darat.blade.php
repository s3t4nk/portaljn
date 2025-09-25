<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Surat Keterangan Penghasilan - {{ $employee->name }}</title>

    <!-- Optional: gunakan font Google (bisa diganti) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --brand:#0b66b3;
            --paper-width:800px;        /* tampilan pada layar, cetak = A4 ~ 794px */
            --gutter:20px;
        }

        html,body{
            height:100%;
            margin:0;
            font-family: "Roboto", system-ui, -apple-system, "Segoe UI", "Montserrat", sans-serif;
            background:#f3f6fa;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
        }

        .page {
            width:var(--paper-width);
            margin:10px auto;
            background:#fff;
            padding:15px;
            box-sizing:border-box;
            page-break-inside: avoid;
        }

        /* Header */
        .header {
            display:flex;
            align-items:center;
            gap:10px;
            border-bottom:4px solid var(--brand);
            padding-bottom:6px;
            margin-bottom:10px;
        }

        .logo {
            width:80px;
            height:80px;
            flex:0 0 80px;
            display:flex;
            align-items:center;
            justify-content:center;
        }
        .logo img{ max-width:100%; height:auto; display:block; }

        .company {
            flex:1;
        }
        .company .name{
            font-family:"Montserrat",sans-serif;
            font-weight:800;
            font-size:18px;
            color:var(--brand);
            letter-spacing:0.6px;
        }
        .company .tagline{
            font-size:10px;
            color:#6b7b8c;
            margin-top:2px;
        }

        /* Title */
        .title {
            text-align:center;
            font-weight:800;
            font-size:16px;
            margin:10px 0 12px;
            letter-spacing:0.6px;
        }

        /* Two-column info area */
        .info {
            display:flex;
            gap:10px;
            margin-bottom:10px;
        }

        .info .left, .info .right{
            flex:1;
            min-width:0;
        }

        .info dl{
            margin:0;
            display:grid;
            grid-template-columns:100px 1fr;
            row-gap:4px;
            column-gap:6px;
            align-items:start;
        }
        .info dt{
            color:#222;
            font-weight:600;
            font-size:12px;
        }
        .info dd{
            margin:0;
            font-size:12px;
            color:#222;
        }

        .section-note {
            margin:8px 0 10px;
            color:#333;
            font-size:12px;
        }

        /* Table-like listing with right aligned amounts */
        .ledger {
            display:flex;
            gap:10px;
            align-items:flex-start;
        }
        .ledger .desc {
            flex:1;
            padding-right:6px;
        }
        .ledger .amount {
            width:120px;
            text-align:right;
            font-family:monospace;
            font-weight:700;
        }

        .ledger .line-item{
            display:flex;
            justify-content:space-between;
            padding:4px 0;
            border-bottom:0px solid rgba(0,0,0,0.02);
        }
        .ledger .line-item .label{
            font-weight:500;
            color:#222;
        }
        .ledger .line-item .sub{
            color:#555;
            font-weight:400;
            font-size:11px;
            margin-left:6px;
        }

        /* Heading row for columns */
        .col-heads{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-top:4px;
            margin-bottom:6px;
        }
        .col-heads .lefthead{
            letter-spacing:4px;
            font-weight:700;
            font-size:12px;
        }
        .col-heads .righthead{
            font-weight:700;
            font-size:12px;
        }

        /* Summary block */
        .summary {
            margin-top:8px;
            border-top:1px solid #222;
            padding-top:4px;
            display:flex;
            justify-content:flex-end;
            gap:12px;
            align-items:center;
        }
        .summary .label{ font-weight:700; font-size:12px; }
        .summary .value{ font-weight:800; font-family:monospace; font-size:14px; }

        /* Deductions and netto */
        .deductions{ margin-top:10px; }
        .deductions .title{ font-weight:700; font-size:12px; margin-bottom:6px; }

        /* Signatures + stamp area */
        .footer {
            margin-top:18px;
            display:flex;
            justify-content:space-between;
            align-items:flex-end;
            gap:10px;
        }
        .sign {
            width:40%;
            text-align:center;
            font-size:11px;
        }
        .sign .name{ font-weight:800; margin-top:20px; }
        .sign .title{ color:#444; font-size:11px; margin-top:4px; }

        .stamp {
            width:100px;
            height:100px;
            background-size:contain;
            background-repeat:no-repeat;
            background-position:center;
            opacity:0.95;
        }

        /* print-friendly */
        @media print{
            body{ background: #fff; }
            .page{ box-shadow:none; margin:0; width:100%; }
            .logo img{ max-width:100%; }
        }

        /* small screens: scale down */
        @media (max-width:900px){
            :root{ --paper-width:94%; }
            .info{ flex-direction:column; gap:6px; }
            .footer{ flex-direction:column; align-items:flex-start; gap:8px; }
            .sign{ width:100%; text-align:left; }
        }
    </style>
</head>
<body>
    <div class="page" role="document" aria-label="Surat Keterangan Penghasilan">
        <header class="header" role="banner">
            <div class="logo" aria-hidden="true">
                <!-- Ganti src dengan logo perusahaan -->
                @if($company['logo'])
                    <img src="{{ $company['logo'] }}" alt="Logo PT Jembatan Nusantara" />
                @endif
            </div>
            <div class="company">
                <div class="name">PT JEMBATAN NUSANTARA</div>
                <div class="tagline">WE LOVE INDONESIA</div>
            </div>
        </header>

        <main>
            <div class="title">SURAT KETERANGAN PENGHASILAN</div>

            <section class="info" aria-labelledby="penanda">
                <div class="left">
                    <p style="margin:0 0 6px;">Yang bertanda tangan dibawah ini :</p>
                    <dl>
                        <dt>Nama</dt><dd><strong>{{ $gm_data['name'] }}</strong></dd>
                        <dt>NIP</dt><dd>{{ $gm_data['nik'] }}</dd>
                        <dt>Jabatan</dt><dd>{{ $gm_data['position'] }}</dd>
                        <dt>Berkedudukan</dt><dd>{{ $gm_data['address'] }}</dd>
                    </dl>
                </div>

                <div class="right">
                    <p style="margin:0 0 6px;">Menerangkan bahwa :</p>
                    <dl>
                        <dt>Nama</dt><dd><strong>{{ $employee->name }}</strong></dd>
                        <dt>NIP</dt><dd>{{ $employee->employee_number }}</dd>
                        <dt>Jabatan</dt><dd>{{ $employee->position?->name ?? '-' }}</dd>
                        <dt>Cabang</dt><dd>{{ $employee->branch?->name ?? 'PT. JEMBATAN NUSANTARA PUSAT' }}</dd>
                    </dl>
                </div>
            </section>

            <p class="section-note">Berdasarkan pembayaran periode Bulan {{ \Carbon\Carbon::parse($history->period)->locale('id')->format('F Y') }} mempunyai penghasilan/gaji dengan rincian sebagai berikut :</p>

            <div class="col-heads">
                <div class="lefthead">N D&nbsp;&nbsp;&nbsp;K E T E R A N G A N</div>
                <div class="righthead">JUMLAH</div>
            </div>

            <!-- daftar penghasilan -->
            <section aria-label="Rincian penghasilan">
                <div class="ledger">
                    <div class="desc">
                        <div class="line-item">
                            <div class="label">1 &nbsp;&nbsp;Gaji Pokok</div>
                            <div class="amount">Rp {{ number_format($history->base_salary, 0, ',', '.') }}</div>
                        </div>

                        <div class="line-item">
                            <div class="label">2 &nbsp;&nbsp;Tunjangan Lainnya</div>
                            <div class="amount">Rp {{ number_format($tunjanganTotal, 0, ',', '.') }}</div>
                        </div>

                        <!-- sub items -->
                        <div style="padding-left:20px;">
                            @foreach ($employee->salaryComponents as $component)
                                <div class="line-item">
                                    <div class="label"><span class="sub">{{ $loop->iteration }}.{{ $loop->parent->iteration }} {{ $component->name }}</span></div>
                                    <div class="amount">Rp {{ number_format($component->pivot->amount, 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="line-item" style="margin-top:6px;">
                            <div class="label">Jumlah Penghasilan</div>
                            <div class="amount">Rp {{ number_format($history->total_salary, 0, ',', '.') }}</div>
                        </div>

                        <!-- potongan -->
                        <div class="deductions">
                            <div class="title">3 &nbsp;&nbsp;Potongan - potongan :</div>
                            <div>
                                <div class="line-item"><div class="label">3.1 BPJS Tenaga Kerja (JHT, JKK, JKM)</div><div class="amount">Rp 99.235</div></div>
                                <div class="line-item"><div class="label">3.2 BPJS Tenaga Kerja (PENSIUN)</div><div class="amount">Rp 49.618</div></div>
                                <div class="line-item"><div class="label">3.3 BPJS Kesehatan</div><div class="amount">Rp 49.618</div></div>
                                <div class="line-item"><div class="label">3.5 Lain-lain</div><div class="amount">Rp 1.000</div></div>
                            </div>

                            <div class="line-item" style="margin-top:6px;">
                                <div class="label">Jumlah Potongan</div><div class="amount">Rp 199.470</div>
                            </div>

                            <div class="line-item" style="margin-top:8px; border-top:1px dashed rgba(0,0,0,0.08); padding-top:8px;">
                                <div class="label" style="font-weight:800;">Jumlah Penghasilan Netto</div><div class="amount" style="font-size:14px;">Rp {{ number_format($history->total_salary - 199470, 0, ',', '.') }}</div>
                            </div>

                        </div>

                    </div>

                    <!-- kolom kanan jumlah -->
                    <div style="width:120px;">
                        <!-- kosong: kolom jumlah sudah dijelaskan pada setiap baris -->
                    </div>
                </div>
            </section>

            <!-- terbilang -->
            <p style="margin-top:12px; font-style:italic; font-weight:600; text-align:left; font-size:12px;">
                ( {{ \NumberToWords\NumberToWords::convert($history->total_salary - 199470) }} )
            </p>

            <!-- signatures and stamp -->
            <div class="footer" role="contentinfo">
                <div class="sign">
                    <div>Mengetahui,</div>
                    <div class="title">MANAGER SDM</div>
                    <div class="name">{{ $gm_data['name'] }}</div>
                </div>

                <div class="stamp" aria-hidden="true" style="background-image:url('{{ $company['logo'] }}');"></div>

                <div class="sign" style="text-align:center;">
                    <div>Surabaya, {{ now()->format('d F Y') }}</div>
                    <div class="title">Pembuat Daftar Gaji</div>
                    <div class="name">{{ $creator_data['name'] }}</div>
                </div>
            </div>

            <!-- footer contact -->
            <footer style="margin-top:12px; font-size:10px; color:#6a6f73;">
                <div>Head Office Surabaya • Gedung Pelni Heritage Lt.2 • Jl. Pahlawan No.112-114 Surabaya 60175</div>
                <div>Telp. +62 31 9922 0000 (Hunting)</div>
            </footer>

        </main>
    </div>
</body>
</html>