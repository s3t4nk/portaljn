<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\Unit;
use App\Modules\HRIS\Models\Department;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('department')->get();
        $departments = Department::orderBy('name')->get(); // untuk dropdown
        return view('modules.hris.units.index', compact('units', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string'
        ]);

        Unit::create($request->all());

        return redirect()->route('hris.units.index')
            ->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'description' => 'nullable|string'
        ]);

        $unit->update($request->all());

        return redirect()->route('hris.units.index')
            ->with('success', 'Unit kerja berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('hris.units.index')
            ->with('success', 'Unit kerja berhasil dihapus.');
    }
}