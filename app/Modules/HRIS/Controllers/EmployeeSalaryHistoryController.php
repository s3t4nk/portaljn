<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\EmployeeSalaryHistory;
use App\Modules\HRIS\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;

class EmployeeSalaryHistoryController extends Controller
{
    public function downloadSlip($id, Request $request)
    {
        $employee = Employee::with(['position', 'unit'])->findOrFail($id);
        $period = $request->input('period');

        // Jika tidak ada period, ambil yang terbaru
        if (!$period) {
            $history = $employee->getLastSalaryAttribute();
        } else {
            $history = $employee->salaryHistories()->where('period', $period)->first();
        }

        if (!$history) {
            return back()->with('error', 'Data gaji untuk periode ini tidak ditemukan.');
        }

        // Logo → base64
        $logoPath = public_path('images/logo.png');
        $logoBase64 = file_exists($logoPath)
            ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
            : null;

        // Data GM
        $gmData = [
            'name' => 'Ir. Ahmad Fauzi',
            'position' => 'General Manager SDM & Pengembangan Bisnis',
            'nik' => 'GM001',
            'date' => now()->format('d-m-Y H:i:s'),
            'employee_id' => $employee->id,
            'period' => $history->period
        ];

        // Generate QR Code sebagai SVG string
        $renderer = new ImageRenderer(
            new RendererStyle(100),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        $qrCodeSvg = $writer->writeString(json_encode($gmData));
        $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);

        $data = [
            'employee' => $employee,
            'history' => $history,
            'company' => [
                'name' => 'PT. JEMBATAN NUSANTARA',
                'logo' => $logoBase64
            ],
            'gm_data' => $gmData,
            'qr_code' => $qrCodeBase64
        ];

        $pdf = Pdf::loadView('modules.hris.employees.salary_slip', $data)
            ->setPaper('A4', 'landscape');

        return $pdf->download("slip-gaji-{$employee->employee_number}-{$history->period}.pdf");
    }
}
