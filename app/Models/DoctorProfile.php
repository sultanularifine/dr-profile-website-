<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $fillable = [
        'user_id', 'doctor_id', 'full_name', 'professional_title', 'bmdc_registration', 'gender',
        'phone', 'public_email', 'biography', 'profile_photo', 'cover_image',
        'qualifications', 'specializations', 'professional_memberships', 'awards',
        'publications', 'languages', 'services', 'years_experience', 'is_visible',
        'is_featured', 'verification_status',
    ];

    protected $casts = [
        'qualifications' => 'array',
        'specializations' => 'array',
        'professional_memberships' => 'array',
        'awards' => 'array',
        'publications' => 'array',
        'languages' => 'array',
        'services' => 'array',
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
