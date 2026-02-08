<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Patient extends Model
{   
    protected $casts = [
        'region' => 'array',
        'province' => 'array',
        'city' => 'array',
        'barangay' => 'array',
    ];

    
    protected $fillable = [
        'patient_code',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'gender',
        'birth_date',
        'blood_type',
        'medical_condition',
        'region',
        'province',
        'city',
        'barangay',
        'contact_number',
        'email',
        'patient_role',
    ];

    protected $appends = ['age', 'full_name'];

    public function getRegionAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getProvinceAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getCityAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getBarangayAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getAgeAttribute()
    {
        return $this->birth_date
            ? Carbon::parse($this->birth_date)->age
            : null;
    }

    public function getFullNameAttribute()
    {
        return trim(
            "{$this->first_name} {$this->middle_name} {$this->last_name} {$this->suffix}"
        );
    }
}
