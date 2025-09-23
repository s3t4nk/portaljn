<?php

namespace App\Modules\HRIS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Modules\HRIS\Models\Employee;
use App\Modules\HRIS\Models\CertificateCategory;
use Illuminate\Support\Facades\Log;

class EmployeeCertificate extends Model
{
    protected $fillable = [
        'nik',
        'category_id',
        'type',
        'number',
        'issued_date',
        'expiry_date',
        'issuing_authority',
        'document_path',
        'is_active'
    ];

    protected $dates = ['issued_date', 'expiry_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'nik', 'nik');
    }

    public function category()
    {
        return $this->belongsTo(CertificateCategory::class);
    }

    public function getDaysLeftAttribute()
    {
        return now()->diffInDays($this->expiry_date, false);
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->expiry_date < now()) {
            return '<span class="badge badge-danger">Kedaluwarsa</span>';
        } elseif ($this->days_left <= 30) {
            return '<span class="badge badge-warning">Akan Habis (' . $this->days_left . ' hari)</span>';
        }
        return '<span class="badge badge-success">Aktif</span>';
    }

    public function getDocumentUrlAttribute()
    {
        return $this->document_path ? Storage::url($this->document_path) : '#';
    }
    
}