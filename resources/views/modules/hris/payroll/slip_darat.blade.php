<div class="container">
    <h3>SLIP GAJI PEGAWAI DARAT</h3>
    <p>Nama: {{ $employee->name }}</p>
    <p>Periode: {{ \Carbon\Carbon::parse($history->period . '-01')->format('F Y') }}</p>
    <hr>
    <h5>Pendapatan</h5>
    <p>Gaji Pokok: Rp {{ number_format($history->base_salary, 0, ',', '.') }}</p>
    @foreach(json_decode($history->components, true) as $comp)
        <p>{{ $comp['name'] }}: Rp {{ number_format($comp['amount'], 0, ',', '.') }}</p>
    @endforeach
    <hr>
    <h5>Potongan</h5>
    <p>BPJS Kesehatan: Rp {{ number_format($employee->bpjs_kesehatan_potongan ?? 0, 0, ',', '.') }}</p>
    <p>BPJS Ketenagakerjaan: Rp {{ number_format($employee->bpjs_ketenagakerjaan_potongan ?? 0, 0, ',', '.') }}</p>
    <p>PPh 21: Rp {{ number_format($employee->pph21_potongan ?? 0, 0, ',', '.') }}</p>
    <hr>
    <h4>Total Diterima: Rp {{ number_format($history->total_salary, 0, ',', '.') }}</h4>
</div>