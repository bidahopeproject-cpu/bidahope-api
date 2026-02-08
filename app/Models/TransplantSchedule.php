<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransplantSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'organ_id',
        'patient_waitlist_id',
        'schedule_date',
        'schedule_time',
        'status',
        'remarks',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function organ()
    {
        return $this->belongsTo(Organ::class);
    }

    public function waitlist()
    {
        return $this->belongsTo(PatientWaitlist::class, 'patient_waitlist_id');
    }
}
