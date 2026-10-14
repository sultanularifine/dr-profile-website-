<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    protected $fillable = [
        'prescription_id', 'sort_order', 'medicine_name', 'strength', 'dosage',
        'route', 'frequency', 'duration', 'quantity', 'instructions',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
