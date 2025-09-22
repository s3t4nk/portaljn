<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\SalaryGrade;
use Illuminate\Http\Request;

class SalaryGradeController extends Controller
{
    public function index()
    {
        $salaryGrades = SalaryGrade::orderBy('grade', 'desc')
            ->orderBy('class')
            ->orderBy('subclass')
            ->get();
        return view('modules.hris.salary_grades.index', compact('salaryGrades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade' => 'required|integer|between:1,7',
            'class' => 'required|string|size:1|in:A,B,C,D',
            'subclass' => 'required|integer|between:1,3',
            'base_salary' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        // Auto-generate code: VII-C1
        $code = "{$request->grade}-{$request->class}{$request->subclass}";

        SalaryGrade::create(array_merge($request->all(), ['code' => $code]));

        return redirect()->route('hris.salary_grades.index')
            ->with('success', "Grade Gaji {$code} berhasil ditambahkan.");
    }

    public function update(Request $request, SalaryGrade $salaryGrade)
    {
        $request->validate([
            'grade' => 'required|integer|between:1,7',
            'class' => 'required|string|size:1|in:A,B,C,D',
            'subclass' => 'required|integer|between:1,3',
            'base_salary' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        // Re-generate code
        $code = "{$request->grade}-{$request->class}{$request->subclass}";

        $salaryGrade->update(array_merge($request->all(), ['code' => $code]));

        return redirect()->route('hris.salary_grades.index')
            ->with('success', "Grade Gaji {$code} berhasil diperbarui.");
    }

    public function destroy(SalaryGrade $salaryGrade)
    {
        $code = $salaryGrade->code;
        $salaryGrade->delete();

        return redirect()->route('hris.salary_grades.index')
            ->with('success', "Grade Gaji {$code} berhasil dihapus.");
    }
}