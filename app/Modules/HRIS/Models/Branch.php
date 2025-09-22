<?php

namespace App\Modules\HRIS\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';
    protected $fillable = [
        'name', 'type', 'kelas', 'address', 'phone', 'latitude', 'longitude'
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}