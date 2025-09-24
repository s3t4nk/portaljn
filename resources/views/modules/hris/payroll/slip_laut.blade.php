<div class="container">
    <h3>SLIP GAJI PEGAWAI LAUT</h3>
    <p>Nama: {{ $employee->name }}</p>
    <p>Periode: {{ \Carbon\Carbon::parse($history->period . '-01')->format('F Y') }}</p>
    <hr>
    <h5>Pendapatan</h5>
    <p>Gaji Pokok: Rp {{ number_format($history->base_salary, 0, ',', '.') }}</p>
    @foreach(json_decode($history->components, true) as $comp)
        <p>{{ $comp['name'] }}: Rp {{ number_format($comp['amount'], 0, ',', '.') }}</p>
    @endforeach
    <p><strong>Tunjangan Laut:</strong> Rp {{ number_format($employee->tunjangan_laut ?? 1500000, 0, ',', '.') }}</p>
    <hr>
    <h5>Potongan</h5>
    <p><em>*(Tidak ada potongan BPJS/PPh21 sesuai kebijakan)*</em></p>
    <hr>
    <h4>Total Diterima: Rp {{ number_format($history->total_salary + ($employee->tunjangan_laut ?? 1500000), 0, ',', '.') }}</h4>
</div>