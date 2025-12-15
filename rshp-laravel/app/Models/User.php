<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'iduser';
    
    // INI YANG PENTING BIAR GAK ERROR updated_at
    public $timestamps = false; 

    protected $fillable = [
        'nama', 'email', 'password', 'spesialisasi',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // RELASI
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'iduser', 'idrole');
    }

    // Relasi profil lain (opsional, biar lengkap)
    public function dokterData() { return $this->hasOne(Dokter::class, 'id_user', 'iduser'); }
    public function perawatData() { return $this->hasOne(Perawat::class, 'id_user', 'iduser'); }
    public function resepsionisData() { return $this->hasOne(Resepsionis::class, 'id_user', 'iduser'); }
    public function pemilik() { return $this->hasOne(Pemilik::class, 'iduser', 'iduser'); }
}