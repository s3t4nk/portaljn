<?php

namespace App\Modules\HRIS\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleMenu;
use Illuminate\Http\Request;

class MenuManagementController extends Controller
{
    public function index()
    {
        $modules = Module::with('menus.children')->orderBy('order')->get();
        return view('modules.hris.admin.menu.index', compact('modules'));
    }

    // === MODUL: TAMPILKAN FORM TAMBAH ===
    public function createModule()
    {
        return view('modules.hris.admin.menu.create_module');
    }

    // === MODUL: SIMPAN KE DATABASE ===
    public function storeModule(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:50|unique:modules,slug',
            'icon' => 'nullable|string|max:50',
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        Module::create($request->all());
        return redirect()->route('hris.admin.menu.index')->with('success', 'Modul berhasil ditambahkan.');
    }

    // === MODUL: EDIT ===
    public function editModule(Module $module)
    {
        return view('modules.hris.admin.menu.edit_module', compact('module'));
    }

    // === MODUL: UPDATE ===
    public function updateModule(Request $request, Module $module)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'slug' => 'required|string|max:50|unique:modules,slug,' . $module->id,
            'icon' => 'nullable|string|max:50',
            'order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        $module->update($request->all());
        return redirect()->route('hris.admin.menu.index')->with('success', 'Modul berhasil diperbarui.');
    }

    // === MODUL: HAPUS ===
    public function destroyModule(Module $module)
    {
        $module->delete();
        return redirect()->route('hris.admin.menu.index')->with('success', 'Modul berhasil dihapus.');
    }

    // === MENU: TAMPILKAN FORM TAMBAH ===
    public function createMenu()
    {
        $modules = Module::pluck('name', 'id');
        $parents = ModuleMenu::whereNull('parent_id')->pluck('text', 'id');
        return view('modules.hris.admin.menu.create_menu', compact('modules', 'parents'));
    }

    // === MENU: SIMPAN ===
    public function storeMenu(Request $request)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'text' => 'required|string|max:100',
            'url' => 'nullable|string|max:200',
            'icon' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:module_menus,id',
            'order' => 'integer|min:0',
            'permission' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        ModuleMenu::create($request->all());
        return redirect()->route('hris.admin.menu.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    // === MENU: EDIT ===
    public function editMenu(ModuleMenu $menu)
    {
        $modules = Module::pluck('name', 'id');
        $parents = ModuleMenu::where('module_id', $menu->module_id)
            ->whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->pluck('text', 'id');

        return view('modules.hris.admin.menu.edit_menu', compact('menu', 'modules', 'parents'));
    }

    // === MENU: UPDATE ===
    public function updateMenu(Request $request, ModuleMenu $menu)
    {
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'text' => 'required|string|max:100',
            'url' => 'nullable|string|max:200',
            'icon' => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:module_menus,id',
            'order' => 'integer|min:0',
            'permission' => 'nullable|string|max:50',
            'is_active' => 'boolean'
        ]);

        $menu->update($request->all());
        return redirect()->route('hris.admin.menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    // === MENU: HAPUS ===
    public function destroy(ModuleMenu $menu)
    {
        $menu->delete();
        return redirect()->route('hris.admin.menu.index')->with('success', 'Menu berhasil dihapus.');
    }
}