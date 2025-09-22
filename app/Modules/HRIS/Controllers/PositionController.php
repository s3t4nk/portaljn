<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\Position;
use App\Modules\HRIS\Models\SalaryGrade;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::with('salaryGrade')->get();
        $salaryGrades = SalaryGrade::orderBy('grade', 'desc')
            ->orderBy('class')
            ->orderBy('subclass')
            ->get();

        return view('modules.hris.positions.index', compact('positions', 'salaryGrades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'salary_grade_id' => 'required|exists:salary_grades,id',
            'type' => 'required|in:struktural,fungsional,operasional',
            'employee_type' => 'required|in:darat,laut,semua',
            'min_experience_years' => 'nullable|integer|min:0',
            'code' => 'required|string|max:20|unique:positions,code',
            'description' => 'nullable|string',
            'is_management' => 'boolean'
        ]);

        // Default empty array for certifications if not set
        $data = $request->all();
        $data['required_certifications'] = $request->has('required_certifications') 
            ? json_decode($request->required_certifications, true) 
            : [];

        Position::create($data);

        return redirect()->route('hris.positions.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'salary_grade_id' => 'required|exists:salary_grades,id',
            'type' => 'required|in:struktural,fungsional,operasional',
            'employee_type' => 'required|in:darat,laut,semua',
            'min_experience_years' => 'nullable|integer|min:0',
            'code' => 'required|string|max:20|unique:positions,code,' . $position->id,
            'description' => 'nullable|string',
            'is_management' => 'boolean'
        ]);

        $data = $request->all();
        $data['required_certifications'] = $request->has('required_certifications') 
            ? json_decode($request->required_certifications, true) 
            : [];

        $position->update($data);

        return redirect()->route('hris.positions.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('hris.positions.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }
}