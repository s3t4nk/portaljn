<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleMenu extends Model
{
    protected $fillable = [
        'module_id', 'text', 'url', 'icon', 'parent_id', 'permission', 'is_active', 'order'
    ];

    public function children()
    {
        return $this->hasMany(ModuleMenu::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(ModuleMenu::class, 'parent_id');
    }
}