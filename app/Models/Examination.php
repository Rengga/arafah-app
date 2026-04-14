<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Examination extends Model
{
    protected $fillable = [
        'doctor_id', 
        'nama_pasien', 
        'waktu_pemeriksaan', 
        'tinggi_badan', 
        'berat_badan', 
        'systole', 
        'diastole', 
        'heart_rate', 
        'respiration_rate', 
        'suhu', 
        'catatan', 
        'berkas_pemeriksaan'
    ];

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}