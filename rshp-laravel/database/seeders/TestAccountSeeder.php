<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestAccountSeeder extends Seeder
{
    public function run()
    {
        // Password default
        $password = Hash::make('12345678');
        $now = Carbon::now();

        // --- 1. AKUN ADMINISTRATOR ---
        $adminId = DB::table('users')->insertGetId([
            'nama' => 'Admin RSHP',
            'email' => 'admin@rshp.com',
            'username' => 'admin', // Sesuaikan kolom di DB kamu (username/name?)
            'password' => $password,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        // Set Role (Asumsi ID Role 1 = Administrator)
        DB::table('role_user')->insert(['iduser' => $adminId, 'idrole' => 1]);


        // --- 2. AKUN DOKTER ---
        $dokterId = DB::table('users')->insertGetId([
            'nama' => 'Dr. Hewan Budi',
            'email' => 'dokter@rshp.com',
            'username' => 'dokter',
            'password' => $password,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('role_user')->insert(['iduser' => $dokterId, 'idrole' => 2]); // Asumsi ID Role 2 = Dokter
        // Isi tabel profil dokters
        DB::table('dokters')->insert([
            'id_user' => $dokterId,
            'alamat' => 'Jl. Kesehatan Hewan No. 1',
            'no_hp' => '08123456701',
            'jenis_kelamin' => 'L',
            'bidang_dokter' => 'Bedah Hewan Kecil',
            'created_at' => $now, 'updated_at' => $now,
        ]);


        // --- 3. AKUN PERAWAT ---
        $perawatId = DB::table('users')->insertGetId([
            'nama' => 'Suster Siti',
            'email' => 'perawat@rshp.com',
            'username' => 'perawat',
            'password' => $password,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('role_user')->insert(['iduser' => $perawatId, 'idrole' => 3]); // Asumsi ID Role 3 = Perawat
        // Isi tabel profil perawats
        DB::table('perawats')->insert([
            'id_user' => $perawatId,
            'alamat' => 'Jl. Melati No. 45',
            'no_hp' => '08123456702',
            'jenis_kelamin' => 'P',
            'pendidikan' => 'D3 Kesehatan Hewan',
            'created_at' => $now, 'updated_at' => $now,
        ]);


        // --- 4. AKUN RESEPSIONIS ---
        $resepsionisId = DB::table('users')->insertGetId([
            'nama' => 'Mbak Resepsionis',
            'email' => 'resepsionis@rshp.com',
            'username' => 'resepsionis',
            'password' => $password,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('role_user')->insert(['iduser' => $resepsionisId, 'idrole' => 4]); // Asumsi ID Role 4 = Resepsionis
        // Isi tabel profil resepsionis
        DB::table('resepsionis')->insert([
            'id_user' => $resepsionisId,
            'alamat' => 'Jl. Depan No. 10',
            'no_hp' => '08123456703',
            'created_at' => $now, 'updated_at' => $now,
        ]);


        // --- 5. AKUN PEMILIK ---
        $pemilikId = DB::table('users')->insertGetId([
            'nama' => 'Pak Bos Pemilik',
            'email' => 'pemilik@rshp.com',
            'username' => 'pemilik',
            'password' => $password,
            'created_at' => $now, 'updated_at' => $now,
        ]);
        DB::table('role_user')->insert(['iduser' => $pemilikId, 'idrole' => 5]); // Asumsi ID Role 5 = Pemilik
        // Isi tabel profil pemilik
        DB::table('pemilik')->insert([
            'iduser' => $pemilikId, // Perhatikan kolom FK pemilik biasanya 'iduser'
            'alamat' => 'Jl. Sultan No. 99',
            'no_wa' => '08123456704',
            'created_at' => $now, 'updated_at' => $now,
        ]);
    }
}