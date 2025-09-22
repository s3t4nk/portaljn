<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'is_active', 'order'];

    public function menus()
    {
        return $this->hasMany(ModuleMenu::class, 'module_id');
    }
}