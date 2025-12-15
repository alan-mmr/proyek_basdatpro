<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resepsionis extends Model
{
    use HasFactory;

    // Nama tabel singular (sesuai database Boss)
    protected $table = 'resepsionis';
    
    // Primary Key Custom
    protected $primaryKey = 'id_resepsionis';

    // Kolom yang boleh diisi lewat form
    protected $fillable = [
        'alamat',
        'no_hp',
        'id_user' // Foreign key ke tabel user
    ];

    // Relasi ke User
    public function user()
    {
        // Parameter: (Model Induk, Foreign Key di sini, Primary Key di Induk)
        return $this->belongsTo(User::class, 'id_user', 'iduser');
    }
}