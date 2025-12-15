<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// --- TAMBAHAN BARU: Import Hash untuk password ---
use Illuminate\Support\Facades\Hash; 
// -------------------------------------------------
use App\Models\Dokter;
use App\Models\Perawat;
use App\Models\Resepsionis;
use App\Models\Pemilik;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan Form Edit
     */
    public function edit()
    {
        $user = Auth::user();
        
        $dokterData      = $user->dokterData;
        $perawatData     = $user->perawatData;
        $resepsionisData = $user->resepsionisData;
        $pemilikData     = $user->pemilik; 

        // TRICK: Mapping 'no_wa' Database ke properti 'no_hp' Virtual
        if($pemilikData) {
            $pemilikData->no_hp = $pemilikData->no_wa; 
        }

        return view('profile.edit', compact('user', 'dokterData', 'perawatData', 'resepsionisData', 'pemilikData'));
    }

    /**
     * Simpan Data Profil (Action)
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        // Ambil nama role (Pastikan user punya role)
        $role = $user->roles->first()->nama_role ?? '';

        // --- 1. DOKTER ---
        if (stripos($role, 'dokter') !== false) {
            $request->validate([
                'alamat'        => 'required|string|max:255',
                'no_hp'         => 'required|numeric',
                'bidang_dokter' => 'required|string',
                'jenis_kelamin' => 'required|in:L,P',
            ]);

            Dokter::updateOrCreate(
                ['id_user' => $user->iduser],
                [
                    'alamat'        => $request->alamat, 
                    'no_hp'         => $request->no_hp, 
                    'bidang_dokter' => $request->bidang_dokter, 
                    'jenis_kelamin' => $request->jenis_kelamin
                ]
            );
        }

        // --- 2. PERAWAT ---
        elseif (stripos($role, 'perawat') !== false) {
            $request->validate([
                'alamat'        => 'required|string|max:255', 
                'no_hp'         => 'required|numeric', 
                'jenis_kelamin' => 'required|in:L,P', 
                'pendidikan'    => 'required|string'
            ]);

            Perawat::updateOrCreate(
                ['id_user' => $user->iduser],
                [
                    'alamat'        => $request->alamat, 
                    'no_hp'         => $request->no_hp, 
                    'jenis_kelamin' => $request->jenis_kelamin, 
                    'pendidikan'    => $request->pendidikan
                ]
            );
        }

        // --- 3. RESEPSIONIS ---
        elseif (stripos($role, 'resepsionis') !== false) {
            $request->validate([
                'alamat' => 'required|string|max:255', 
                'no_hp'  => 'required|numeric'
            ]);

            Resepsionis::updateOrCreate(
                ['id_user' => $user->iduser],
                [
                    'alamat' => $request->alamat, 
                    'no_hp'  => $request->no_hp
                ]
            );
        }

        // --- 4. PEMILIK ---
        elseif (stripos($role, 'pemilik') !== false) {
            $request->validate([
                'alamat' => 'required|string|max:255', 
                'no_hp'  => 'required|numeric'
            ]);
            
            Pemilik::updateOrCreate(
                ['iduser' => $user->iduser],
                [
                    'alamat' => $request->alamat, 
                    'no_wa'  => $request->no_hp 
                ]
            );
        }

        return redirect()->back()->with('success', 'Data profil berhasil diperbarui!');
    }

    /**
     * TAMBAHAN BARU: Update Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password', // Cek pass lama
            'password' => 'required|confirmed|min:8', // Pass baru min 8 & match confirm
        ]);

        $user = Auth::user();
        
        // Update Password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diganti!');
    }
}