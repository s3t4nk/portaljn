<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Module;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */


public function boot()
{
    View::composer('layouts.hris', function ($view) {
        $user = auth()->user();
        $menuItems = [];

        if (!$user) {
            return $view->with('menuItems', []);
        }

        try {
            $modules = \App\Models\Module::where('is_active', 1)->orderBy('order')->get();

            foreach ($modules as $module) {
                $menus = $module->menus()
                    ->where('is_active', 1)
                    ->whereNull('parent_id')
                    ->with(['children' => function ($q) {
                        $q->where('is_active', 1)->orderBy('order');
                    }])
                    ->orderBy('order')
                    ->get();

                foreach ($menus as $menu) {
                    if ($user->can($menu->permission)) {
                        $submenu = $menu->children->map(function ($child) use ($user) {
                            return $user->can($child->permission) ? [
                                'text' => $child->text,
                                'url' => $child->url,
                                'icon' => $child->icon ?? 'far fa-circle',
                                'can' => $child->permission,
                            ] : null;
                        })->filter();

                        $menuItems[] = [
                            'text' => $menu->text,
                            'url' => $menu->url,
                            'icon' => $menu->icon,
                            'can' => $menu->permission,
                            'submenu' => $submenu->count() ? $submenu->toArray() : null
                        ];
                    }
                }
            }

            Log::info('✅ Dynamic Menu Generated:', ['menuItems' => $menuItems]);
        } catch (\Exception $e) {
            Log::error('❌ Menu Composer Error: ' . $e->getMessage());
        }

        $view->with('menuItems', $menuItems);
    });
}

}
