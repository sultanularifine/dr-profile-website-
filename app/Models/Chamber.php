<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chamber extends Model
{
    protected $fillable = [
        'name', 'hospital_name', 'department', 'address', 'phone', 'maps_url',
        'consultation_type', 'consultation_fee', 'is_default', 'is_active', 'display_order',
    ];

    protected $casts = ['is_default' => 'boolean', 'is_active' => 'boolean', 'consultation_fee' => 'decimal:2'];

    public function schedules()
    {
        return $this->hasMany(ChamberSchedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
