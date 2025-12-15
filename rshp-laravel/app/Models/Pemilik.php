<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel yang terkait dengan model ini.
     */
    protected $table = 'pemilik';

    /**
     * Menentukan primary key tabel.
     * Penting: Default Laravel adalah 'id', wajib diubah ke 'idpemilik' agar update/delete berfungsi.
     */
    protected $primaryKey = 'idpemilik';

    /**
     * Menandakan bahwa primary key adalah auto-incrementing integer.
     */
    public $incrementing = true;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'iduser', // Wajib ada untuk relasi ke tabel User
        'alamat', 
        'no_wa'
    ];

    /**
     * =========================================================
     * SOLUSI ERROR "Unknown column 'updated_at'"
     * =========================================================
     * Menonaktifkan timestamp karena tabel 'pemilik' tidak punya 
     * kolom created_at dan updated_at.
     */
    public $timestamps = false; 

    /**
     * =========================================================
     * RELASI KE TABEL USER
     * =========================================================
     * Mendefinisikan bahwa setiap data Pemilik "Milik" satu User (Akun).
     */
    public function user()
    {
        // parameter: (Model Tujuan, Foreign Key di sini, Primary Key di sana)
        return $this->belongsTo(User::class, 'iduser', 'iduser');
    }
}