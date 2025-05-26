<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pemeriksaan';

    protected $fillable = [
        'patient_id',
        'dokter',
        'tanggal',
        'jam',
        'status',
        'keterangan' 
    ];

    protected $casts = [
         'tanggal' => 'date:Y-m-d',
        'jam' => 'datetime:H:i',  // Format disederhanakan
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke model Patient
     * Perhatikan penyesuaian nama method dan parameter
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }


    public function pemeriksaan()
    {
        return $this->hasOne(PemeriksaanGigi::class, 'jadwal_id');
    }

    /**
     * Scope untuk filter status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Accessor untuk format tanggal dan jam
     */
    public function getWaktuPemeriksaanAttribute()
    {
        return $this->tanggal->format('d/m/Y').' '.$this->jam->format('H:i');
    }
 public function dokter()
{
    return $this->belongsTo(User::class, 'dokter_id');
}
}