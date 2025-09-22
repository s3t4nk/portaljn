<?php

namespace App\Modules\HRIS\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';
    protected $fillable = [
        'name', 'salary_grade_id', 'type', 'employee_type',
        'min_experience_years', 'required_certifications', 'code',
        'description', 'is_management'
    ];

    protected $casts = [
        'required_certifications' => 'json'
    ];

    public function salaryGrade()
    {
        return $this->belongsTo(SalaryGrade::class);
    }
}