<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'examination_id','is_served'
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function items()
        {
            return $this->hasMany(\App\Models\PrescriptionItem::class);
        }
}