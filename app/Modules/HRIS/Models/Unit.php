<?php

namespace App\Modules\HRIS\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'units';
    protected $fillable = ['name', 'department_id', 'description'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}