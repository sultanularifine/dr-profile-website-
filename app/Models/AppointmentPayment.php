<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AppointmentPayment extends Model
{
    protected $fillable = [
        'reference', 'appointment_id', 'patient_id', 'method', 'amount',
        'transaction_reference', 'proof_path', 'proof_original_name', 'proof_mime', 'proof_size',
        'status', 'patient_note', 'review_note', 'reviewed_by', 'reviewed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (AppointmentPayment $payment) {
            if (!$payment->reference) {
                $payment->reference = 'PAY-' . now()->format('ymd') . '-' . Str::upper(Str::random(7));
            }
        });
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
