<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentStatusHistory extends Model
{
    protected $fillable = [
        'appointment_id', 'changed_by', 'old_status', 'new_status', 'notes',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
