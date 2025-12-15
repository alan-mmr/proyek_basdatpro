<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RasHewan extends Model
{
    use HasFactory;

    /**
     * NAMA TABEL DI DATABASE
     */
    protected $table = 'ras_hewan';

    /**
     * PRIMARY KEY
     * Sesuaikan dengan screenshot HeidiSQL kamu.
     */
    protected $primaryKey = 'idras_hewan';

    /**
     * TIMESTAMP
     * Set false jika tabel tidak punya kolom created_at & updated_at
     */
    public $timestamps = false; 

    /**
     * KOLOM YANG BISA DIISI (MASS ASSIGNMENT)
     * Penting: 'nama_ras' sesuai database kamu, bukan 'nama'.
     */
    protected $fillable = [
        'nama_ras',      // <--- INI PERBAIKANNYA (Sesuai DB)
        'idjenis_hewan'  // FK ke tabel jenis_hewan
    ];

    // ========================================================================
    // --- RELASI (RELATIONSHIPS) ---
    // ========================================================================

    /**
     * Relasi ke Jenis Hewan.
     * Gunanya: Mengubah ID (misal: 1) menjadi Nama Jenis (misal: Anjing).
     * Pastikan Model JenisHewan sudah ada ya.
     */
    public function jenis()
    {
        // Parameter: (Model Tujuan, FK di tabel ini, PK di tabel sana)
        return $this->belongsTo(JenisHewan::class, 'idjenis_hewan', 'idjenis_hewan');
    }
}