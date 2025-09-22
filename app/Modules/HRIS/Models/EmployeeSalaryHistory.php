<?php

namespace App\Modules\HRIS\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryHistory extends Model
{
    protected $table = 'employee_salary_histories';
    protected $guarded = [];

    protected $casts = [
        'components' => 'json'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}