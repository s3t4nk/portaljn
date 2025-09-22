<?php

namespace App\Modules\HRIS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $table = 'employees';
    protected $guarded = [];

    protected $casts = [
        'joining_date' => 'date',
        'contract_start' => 'date',
        'contract_end' => 'date',
        'birth_date' => 'date'
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function salaryGrade()
    {
        return $this->hasOneThrough(
            SalaryGrade::class,
            Position::class,
            'id',           // FK di positions
            'id',           // FK di salary_grades
            'position_id',  // Lokal di employees
            'salary_grade_id' // Di positions
        );
    }

    public function salaryComponents()
    {
        return $this->belongsToMany(SalaryComponent::class, 'employee_salary_component')
            ->withPivot('amount', 'notes');
    }

    public function salaryHistories()
    {
        return $this->hasMany(EmployeeSalaryHistory::class);
    }

    // Accessor: gaji terakhir
    public function getLastSalaryAttribute()
    {
        return $this->salaryHistories()->latest('period')->first();
    }
}
