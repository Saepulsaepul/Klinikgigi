<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiGigi extends Model
{
    use HasFactory;

    protected $table = 'kondisi_gigi';

    protected $fillable = [
        'pemeriksaan_id',
        'nomor_gigi',
        'kondisi',
        'tindakan',
    ];

    /**
     * Relasi ke PemeriksaanGigi
     */
    public function pemeriksaan()
    {
        return $this->belongsTo(PemeriksaanGigi::class, 'pemeriksaan_id');
    }
}
