<?php

namespace App\Modules\HRIS\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryGrade extends Model
{
    protected $table = 'salary_grades';
    protected $fillable = [
        'grade', 'class', 'subclass', 'code', 'base_salary', 'description'
    ];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}