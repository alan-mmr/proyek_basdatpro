<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pemilik;
use App\Models\User; 
// use App\Models\Pet; // Buka jika sudah ada Model Pet
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PemilikController extends Controller
{
    /**
     * MENAMPILKAN DAFTAR PEMILIK
     */
    public function index()
    {
        // Mengambil data pemilik beserta relasi user-nya
        $pemilik = Pemilik::with('user')->get();
        return view('admin.pemilik.index', compact('pemilik'));
    }

    /**
     * MENAMPILKAN FORM TAMBAH (CREATE)
     */
    public function create()
    {
        return view('admin.pemilik.create');
    }

    /**
     * MENYIMPAN DATA (USER BARU + PROFIL PEMILIK)
     * Status: FIXED (Sudah disesuaikan dengan kolom 'nama' di database)
     */
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT
        // Pastikan input dari form HTML (name="...") sesuai dengan aturan di sini
        $request->validate([
            'name'     => 'required|string|max:255', // Ini nama field di HTML Form
            'email'    => 'required|email|unique:user,email',
            'password' => 'required|min:6',
            'alamat'   => 'required|string',
            'no_wa'    => 'required|numeric',
        ]);

        // 2. MULAI TRANSAKSI DATABASE
        // Kita nyalakan lagi pengamannya biar data konsisten
        DB::beginTransaction(); 
        try {

            // 3. BUAT AKUN USER BARU
            // PERBAIKAN DI SINI: Kiri 'nama' (Database), Kanan $request->name (Input Form)
            $user = User::create([
                'nama'     => $request->name, // <--- SUDAH DIGANTI JADI 'nama'
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // 4. ATTACH ROLE 'PEMILIK' (ID = 5)
            // Memanggil relasi roles() yang ada di Model User
            $user->roles()->attach(5); 

            // 5. BUAT PROFIL PEMILIK
            // Menggunakan ID User yang baru saja dibuat
            Pemilik::create([
                'iduser' => $user->iduser,
                'alamat' => $request->alamat,
                'no_wa'  => $request->no_wa,
            ]);

            // 6. SIMPAN PERMANEN
            DB::commit(); 

            return redirect()->route('admin.pemilik.index')->with('success', 'User & Pemilik berhasil ditambahkan!');

        } catch (\Exception $e) {
            // 7. BATALKAN SEMUA JIKA ERROR
            DB::rollback(); 
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * MENAMPILKAN FORM EDIT
     */
   public function edit($id)
    {
        // Kita panggil relasi 'user' biar datanya siap ditampilkan
        $pemilik = Pemilik::with('user')->findOrFail($id);
        
        return view('admin.pemilik.edit', compact('pemilik'));
    }

    /**
     * UPDATE DATA (HANYA ALAMAT & WA)
     */
    public function update(Request $request, $id)
    {
        // Validasi tanpa 'iduser', karena user tidak diubah di sini
        $request->validate([
            'alamat' => 'required|string|max:255',
            'no_wa'  => 'required|numeric',
        ]);

        try {
            $pemilik = Pemilik::findOrFail($id);
            
            // Update tabel pemilik saja
            $pemilik->update([
                'alamat' => $request->alamat,
                'no_wa'  => $request->no_wa,
            ]);

            return redirect()->route('admin.pemilik.index')->with('success', 'Data Pemilik berhasil diperbarui.');
            
        } catch (Exception $e) {
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }
    
    /**
     * HAPUS DATA (USER + PEMILIK + ROLE)
     */
    public function destroy($id)
    {
        DB::beginTransaction(); // Pakai transaction biar bersih hapusnya
        try {
            // Cari data pemilik & user terkait
            $pemilik = Pemilik::findOrFail($id);
            $user = User::findOrFail($pemilik->iduser);

            // 1. Hapus Profil Pemilik
            $pemilik->delete();

            // 2. Lepas Role User (di tabel pivot role_user)
            $user->roles()->detach();

            // 3. Hapus Akun User
            $user->delete();

            DB::commit();
            return redirect()->route('admin.pemilik.index')->with('success', 'Data Pemilik dan Akun User berhasil dihapus.');

        } catch (Exception $e) {
            DB::rollback();
            
            // Cek error foreign key (misal masih punya hewan)
            if (str_contains($e->getMessage(), 'Constraint violation')) {
                return back()->with('error', 'Gagal menghapus: Pemilik ini masih memiliki data Hewan/Transaksi.');
            }
            
            return back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}