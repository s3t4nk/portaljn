<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\SalaryComponent;
use App\Modules\HRIS\Models\Position;
use Illuminate\Http\Request;

class SalaryComponentController extends Controller
{
    public function index()
    {
        $components = SalaryComponent::with('position')->get();
        $positions = Position::orderBy('name')->get();
        return view('modules.hris.salary_components.index', compact('components', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,percentage',
            'amount' => 'required|numeric|min:0',
            'applicable_to' => 'required|in:grade,position,employee_type',
            'min_grade' => 'nullable|integer|between:1,7',
            'max_grade' => 'nullable|integer|between:1,7',
            'position_id' => 'nullable|exists:positions,id',
            'employee_type' => 'nullable|in:darat,laut,semua',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        SalaryComponent::create($request->all());

        return redirect()->route('hris.salary_components.index')
            ->with('success', 'Komponen gaji berhasil ditambahkan.');
    }

    public function update(Request $request, SalaryComponent $salaryComponent)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,percentage',
            'amount' => 'required|numeric|min:0',
            'applicable_to' => 'required|in:grade,position,employee_type',
            'min_grade' => 'nullable|integer|between:1,7',
            'max_grade' => 'nullable|integer|between:1,7',
            'position_id' => 'nullable|exists:positions,id',
            'employee_type' => 'nullable|in:darat,laut,semua',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $salaryComponent->update($request->all());

        return redirect()->route('hris.salary_components.index')
            ->with('success', 'Komponen gaji berhasil diperbarui.');
    }

    public function destroy(SalaryComponent $salaryComponent)
    {
        $salaryComponent->delete();
        return redirect()->route('hris.salary_components.index')
            ->with('success', 'Komponen gaji berhasil dihapus.');
    }
}