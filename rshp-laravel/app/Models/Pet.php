<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $table = 'pet';
    protected $primaryKey = 'idpet';
    
    // Matikan timestamp karena tabel pet kamu tidak punya created_at/updated_at
    public $timestamps = false; 

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'warna_tanda',
        'jenis_kelamin', // Format: 'J' atau 'B'
        'idpemilik',     // Foreign Key ke Pemilik
        'idras_hewan'    // Foreign Key ke Ras Hewan
    ];

    // ========================================================================
    // --- RELASI (RELATIONSHIPS) ---
    // ========================================================================

    /**
     * Pet ini milik siapa?
     * Menghubungkan ke Model Pemilik.
     */
    public function pemilik()
    {
        return $this->belongsTo(Pemilik::class, 'idpemilik', 'idpemilik');
    }

    /**
     * Pet ini ras-nya apa?
     * Menghubungkan ke Model RasHewan.
     */
    public function ras()
    {
        return $this->belongsTo(RasHewan::class, 'idras_hewan', 'idras_hewan');
    }
}