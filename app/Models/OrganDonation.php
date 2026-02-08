<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganDonation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'organ_id',
        'donation_date',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function organ()
    {
        return $this->belongsTo(Organ::class);
    }
}