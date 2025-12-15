<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisHewan;
use Exception;

class JenisHewanController extends Controller
{
    /**
     * Menampilkan daftar semua jenis hewan.
     */
    public function index()
    {
        $jenisHewan = JenisHewan::all();
        return view('admin.jenis-hewan.index', compact('jenisHewan'));
    }

    /**
     * Menampilkan form untuk menambah data baru.
     */
    public function create()
    {
        return view('admin.jenis-hewan.create');
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $this->validateJenisHewan($request); // Panggil validasi

        try {
            JenisHewan::create([
                'nama_jenis_hewan' => $this->formatNamaJenisHewan($request->nama_jenis_hewan)
            ]);

            return redirect()->route('admin.jenis-hewan.index')
                ->with('success', 'Jenis hewan berhasil ditambahkan.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * 1. EDIT: Menampilkan Form Edit
     * (Mengambil data lama berdasarkan ID, lalu kirim ke View)
     */
    public function edit($id)
    {
        // Cari data berdasarkan Primary Key 'idjenis_hewan'
        $jenisHewan = JenisHewan::where('idjenis_hewan', $id)->firstOrFail();
        
        return view('admin.jenis-hewan.edit', compact('jenisHewan'));
    }

    /**
     * 2. UPDATE: Menyimpan Perubahan
     */
    public function update(Request $request, $id)
    {
        $this->validateJenisHewan($request, $id); // Validasi (abaikan ID sendiri biar gak error unique)

        try {
            $jenisHewan = JenisHewan::where('idjenis_hewan', $id)->firstOrFail();
            
            $jenisHewan->update([
                'nama_jenis_hewan' => $this->formatNamaJenisHewan($request->nama_jenis_hewan)
            ]);

            return redirect()->route('admin.jenis-hewan.index')
                ->with('success', 'Jenis hewan berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * 3. DESTROY: Menghapus Data
     */
    public function destroy($id)
    {
        try {
            $jenisHewan = JenisHewan::where('idjenis_hewan', $id)->firstOrFail();
            $jenisHewan->delete();

            return redirect()->route('admin.jenis-hewan.index')
                ->with('success', 'Jenis hewan berhasil dihapus.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    // --- HELPER FUNCTIONS ---

    protected function validateJenisHewan(Request $request, $id = null)
    {
        // PENTING: Validasi Unique harus mengecualikan ID data yang sedang diedit
        // Format: unique:table,column,except_id,id_column_name
        $uniqueRule = 'unique:jenis_hewan,nama_jenis_hewan';
        if ($id) {
            $uniqueRule .= ',' . $id . ',idjenis_hewan';
        }

        return $request->validate([
            'nama_jenis_hewan' => ['required', 'string', 'max:255', 'min:3', $uniqueRule],
        ], [
            'nama_jenis_hewan.required' => 'Nama jenis hewan wajib diisi.',
            'nama_jenis_hewan.unique' => 'Nama jenis hewan ini sudah ada.',
        ]);
    }

    protected function formatNamaJenisHewan($nama)
    {
        return trim(ucwords(strtolower($nama)));
    }
}