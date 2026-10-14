<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Appointment extends Model
{
    protected $fillable = [
        'appointment_code', 'patient_id', 'chamber_id', 'consultation_type', 'scheduled_at',
        'duration_minutes', 'reason', 'status', 'fee', 'payment_status', 'meeting_provider',
        'meeting_url', 'meeting_id', 'meeting_passcode', 'meeting_instructions', 'meeting_enabled',
        'meeting_manual_override', 'meeting_override_by', 'meeting_override_at', 'meeting_override_reason',
        'consultation_started_at', 'consultation_completed_at', 'admin_notes',
        'booking_source', 'created_by', 'fee_waived', 'fee_waiver_reason',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'consultation_started_at' => 'datetime',
        'consultation_completed_at' => 'datetime',
        'fee' => 'decimal:2',
        'meeting_enabled' => 'boolean',
        'meeting_manual_override' => 'boolean',
        'meeting_override_at' => 'datetime',
        'fee_waived' => 'boolean',
        // Encrypt meeting passcodes at rest using Laravel's APP_KEY.
        'meeting_passcode' => 'encrypted',
    ];

    protected static function booted(): void
    {
        static::creating(function (Appointment $appointment) {
            if (!$appointment->appointment_code) {
                $appointment->appointment_code = 'APT-' . now()->format('ymd') . '-' . Str::upper(Str::random(6));
            }
        });
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    public function statusHistory()
    {
        return $this->hasMany(AppointmentStatusHistory::class)->latest();
    }

    public function payments()
    {
        return $this->hasMany(AppointmentPayment::class)->latest();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function meetingOverrideBy()
    {
        return $this->belongsTo(User::class, 'meeting_override_by');
    }
}
