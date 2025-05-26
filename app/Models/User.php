<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cabang_id',
        'role',
        'telepon',
        'alamat',
        'foto_profil'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function cabang(): BelongsTo {
        return $this->belongsTo(Cabang::class,'cabang_id');
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function isResepsionis(): bool {
        return $this->role === 'resepsionis';
    }

    public function isDokter(): bool {
        return $this->role === 'dokter';
    }
    public function isPasien(): bool {
        return $this->role === 'pasien';
    }
    public function patient() {
        return $this->hasOne(Patient::class);
    }
    public function jadwalsAsDokter()
{
    return $this->hasMany(JadwalPemeriksaan::class, 'dokter_id');
}
}