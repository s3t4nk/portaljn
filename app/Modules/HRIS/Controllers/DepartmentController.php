<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\Department;
use App\Modules\HRIS\Models\Branch;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('branch')->get();
        $branches = Branch::orderBy('name')->get(); // untuk dropdown
        return view('modules.hris.departments.index', compact('departments', 'branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'description' => 'nullable|string'
        ]);

        Department::create($request->all());

        return redirect()->route('hris.departments.index')
            ->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'branch_id' => 'required|exists:branches,id',
            'description' => 'nullable|string',
        ]);

        $department->update($request->all());

        return redirect()->route('hris.departments.index')
            ->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('hris.departments.index')
            ->with('success', 'Departemen berhasil dihapus.');
    }
}
