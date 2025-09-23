<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\CertificateCategory;
use App\Modules\HRIS\Models\EmployeeCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index($nik)
    {
        $certificates = EmployeeCertificate::where('nik', $nik)->with('category')->get();
        return view('modules.hris.certificates.index', compact('certificates', 'nik'));
    }

    public function create($nik)
    {
        $categories = CertificateCategory::all();
        return view('modules.hris.certificates.create', compact('nik', 'categories'));
    }

    public function store(Request $request, $nik)
    {
        $request->validate([
            'type' => 'required|string|max:100',
            'number' => 'required|string|max:50',
            'issued_date' => 'required|date',
            'expiry_date' => 'required|date|after:issued_date',
            'issuing_authority' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:certificate_categories,id',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048'
        ]);

        $data = $request->only(['type', 'number', 'issued_date', 'expiry_date', 'issuing_authority', 'category_id']);
        $data['nik'] = $nik;
        $data['is_active'] = true;


        if ($request->hasFile('document')) {
            $path = $request->file('document')->store("certificates/{$nik}", 'public');
            $data['document_path'] = $path;
        }

        EmployeeCertificate::create($data);

        return redirect()->route('hris.certificates.index', $nik)->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function edit($nik, $id)
    {
        $certificate = EmployeeCertificate::where('nik', $nik)->findOrFail($id);
        $categories = CertificateCategory::all();
        return view('modules.hris.certificates.edit', compact('certificate', 'categories', 'nik'));
    }

    public function update(Request $request, $nik, $id)
    {
        $certificate = EmployeeCertificate::where('nik', $nik)->findOrFail($id);

        $request->validate([
            'type' => 'required|string|max:100',
            'number' => 'required|string|max:50',
            'issued_date' => 'required|date',
            'expiry_date' => 'required|date|after:issued_date',
            'issuing_authority' => 'nullable|string|max:100',
            'category_id' => 'nullable|exists:certificate_categories,id',
            'document' => 'nullable|file|mimes:pdf,jpg,png|max:2048'
        ]);

        $data = $request->only(['type', 'number', 'issued_date', 'expiry_date', 'issuing_authority', 'category_id']);

        if ($request->hasFile('document')) {
            if ($certificate->document_path) {
                Storage::delete($certificate->document_path);
            }
            $path = $request->file('document')->store("certificates/{$nik}");
            $data['document_path'] = $path;
        }

        $certificate->update($data);

        return redirect()->route('modules.hris.certificates.index', $nik)->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy($nik, $id)
    {
        $certificate = EmployeeCertificate::where('nik', $nik)->findOrFail($id);

        if ($certificate->document_path) {
            Storage::delete($certificate->document_path);
        }

        $certificate->delete();

        return redirect()->route('modules.hris.certificates.index', $nik)->with('success', 'Sertifikat berhasil dihapus.');
    }
}
