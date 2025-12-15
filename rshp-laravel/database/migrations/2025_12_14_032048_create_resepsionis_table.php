<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resepsionis', function (Blueprint $table) {
            $table->id('id_resepsionis'); 
            $table->string('alamat', 100)->nullable();
            $table->string('no_hp', 50)->nullable();

            // --- PERBAIKAN DISINI ---
            // Kita pakai 'bigInteger' (bukan unsigned) agar cocok dengan tabel 'user' Boss
            $table->bigInteger('id_user'); 
            
            // Definisikan relasi
            $table->foreign('id_user')
                  ->references('iduser') // Ke kolom iduser
                  ->on('user')           // Ke tabel user
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resepsionis');
    }
};