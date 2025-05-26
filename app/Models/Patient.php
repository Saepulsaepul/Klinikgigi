<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Patient extends Model
{
    use Notifiable;
    protected $fillable = [
        'nama', 'no_ktp', 'no_hp', 'email', 'tanggal_lahir',
        'jenis_kelamin', 'alamat', 'user_id', 'cabang_id', 'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function jadwals()
    {
        return $this->hasMany(JadwalPemeriksaan::class, 'patient_id');
        
    }
    public function patient()
{
    return $this->belongsTo(Patient::class, 'patient_id');
}
}

