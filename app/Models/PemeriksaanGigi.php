<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanGigi extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_gigi';

    protected $fillable = [
        'jadwal_id',
        'tanggal_pemeriksaan',
        'keluhan_pasien',
        'diagnosis',
        'rencana_perawatan',
        'catatan_tambahan',
    ];

    /**
     * Relasi ke Jadwal Pemeriksaan
     */
    public function jadwal()
    {
        return $this->belongsTo(JadwalPemeriksaan::class, 'jadwal_id');
    }

    /**
     * Relasi tidak langsung ke Pasien (melalui Jadwal)
     */
    public function pasien()
    {
        return $this->hasOneThrough(
            Patient::class,
            JadwalPemeriksaan::class,
            'id',          // Foreign key di JadwalPemeriksaan
            'id',          // Foreign key di Pasien
            'jadwal_id',   // Foreign key lokal (di PemeriksaanGigi)
            'pasien_id'    // Foreign key di JadwalPemeriksaan ke Pasien
        );
    }
    public function kondisiGigi()
{
    return $this->hasMany(KondisiGigi::class, 'pemeriksaan_id');
}
    
}
