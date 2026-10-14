<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsentRecord extends Model
{
    protected $fillable = [
        'visitor_hash', 'analytics', 'marketing', 'consent_version', 'consented_at', 'withdrawn_at',
    ];

    protected $casts = [
        'analytics' => 'boolean',
        'marketing' => 'boolean',
        'consented_at' => 'datetime',
        'withdrawn_at' => 'datetime',
    ];
}
