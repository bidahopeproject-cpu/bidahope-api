<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientWaitlist extends Model
{
    use HasFactory;

    protected $table = 'patient_waitlists';

    protected $fillable = [
        'patient_id',
        'organ_id',
        'priority',
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
