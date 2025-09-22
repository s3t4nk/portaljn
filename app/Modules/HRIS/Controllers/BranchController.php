<?php

namespace App\Modules\HRIS\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\HRIS\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('type')->get();
        return view('modules.hris.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('modules.hris.branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pusat,cabang,kapal',
            'kelas' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'latitude' => 'nullable|numeric|min:-90|max:90',
            'longitude' => 'nullable|numeric|min:-180|max:180',
        ]);

        Branch::create($request->all());

        return redirect()->route('hris.branches.index')
            ->with('success', 'Cabang/Kapal berhasil ditambahkan.');
    }

    public function edit(Branch $branch)
    {
        return view('modules.hris.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pusat,cabang,kapal',
            'kelas' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'latitude' => 'nullable|numeric|min:-90|max:90',
            'longitude' => 'nullable|numeric|min:-180|max:180',
        ]);

        $branch->update($request->all());

        return redirect()->route('hris.branches.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('hris.branches.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}