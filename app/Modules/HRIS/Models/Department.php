<?php

namespace App\Modules\HRIS\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = ['name', 'branch_id', 'description'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}