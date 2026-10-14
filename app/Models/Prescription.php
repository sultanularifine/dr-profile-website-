<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prescription extends Model
{
    protected $fillable = [
        'reference', 'appointment_id', 'patient_id', 'author_id', 'type', 'status', 'title',
        'chief_complaints', 'examination_findings', 'diagnosis', 'investigation_advice',
        'general_advice', 'follow_up_date', 'private_file_path', 'original_filename',
        'mime_type', 'file_size', 'published_at', 'generated_pdf_path', 'generated_pdf_generated_at',
    ];

    protected $casts = ['follow_up_date' => 'date', 'published_at' => 'datetime', 'generated_pdf_generated_at' => 'datetime'];

    protected static function booted(): void
    {
        static::creating(function (Prescription $prescription) {
            if (!$prescription->reference) {
                $prescription->reference = 'RX-' . now()->format('ymd') . '-' . Str::upper(Str::random(7));
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

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class)->orderBy('sort_order');
    }
}
