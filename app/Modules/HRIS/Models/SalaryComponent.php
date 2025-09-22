<?php

namespace App\Modules\HRIS\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryComponent extends Model
{
    protected $table = 'salary_components';
    protected $fillable = [
        'name',
        'type',
        'amount',
        'applicable_to',
        'min_grade',
        'max_grade',
        'position_id',
        'employee_type',
        'description',
        'is_active',
        'category'
    ];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function getIsDeductionAttribute()
    {
        return $this->category === 'deduction';
    }

    public function getIsAllowanceAttribute()
    {
        return $this->category === 'allowance';
    }
}
