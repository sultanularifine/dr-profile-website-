<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamberSchedule extends Model
{
    protected $fillable = ['chamber_id', 'weekday', 'starts_at', 'ends_at', 'slot_minutes', 'max_patients', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }
}
