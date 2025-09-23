<?php

namespace App\Modules\HRIS\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\HRIS\Models\EmployeeCertificate;

class CertificateCategory extends Model
{
    protected $fillable = ['name'];

    public function certificates()
    {
        return $this->hasMany(EmployeeCertificate::class, 'category_id');
    }
}