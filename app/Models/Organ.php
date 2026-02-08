<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organ extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    public function donations()
    {
        return $this->hasMany(OrganDonation::class);
    }

    public function waitlists()
    {
        return $this->hasMany(Waitlist::class);
    }
}
