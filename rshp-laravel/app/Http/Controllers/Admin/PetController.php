<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Pemilik;
use App\Models\RasHewan;

class PetController extends Controller
{
    /**
     * TAMPILKAN DAFTAR HEWAN
     */
    public function index()
    {
        // Ambil data pet beserta relasinya biar loading cepat
        $pets = Pet::with(['pemilik.user', 'ras.jenis'])->get();
        return view('admin.pet.index', compact('pets'));
    }

    /**
     * TAMPILKAN FORM TAMBAH
     */
    public function create()
    {
        // Ambil data untuk dropdown
        $pemiliks = Pemilik::with('user')->get(); 
        $ras_hewans = RasHewan::with('jenis')->get();

        return view('admin.pet.create', compact('pemiliks', 'ras_hewans'));
    }

    /**
     * SIMPAN DATA BARU
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:J,B',
            'idpemilik'     => 'required|exists:pemilik,idpemilik',
            'idras_hewan'   => 'required|exists:ras_hewan,idras_hewan',
            'warna_tanda'   => 'nullable|string|max:45',
            'tanggal_lahir' => 'nullable|date',
        ]);

        try {
            Pet::create([
                'nama'          => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'idpemilik'     => $request->idpemilik,
                'idras_hewan'   => $request->idras_hewan,
                'warna_tanda'   => $request->warna_tanda,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]);

            return redirect()->route('admin.pet.index')->with('success', 'Data Hewan berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * TAMPILKAN FORM EDIT (Baru Ditambahkan)
     */
    public function edit($id)
    {
        // Cari data hewan berdasarkan ID
        $pet = Pet::findOrFail($id);

        // Data pendukung untuk dropdown (sama seperti create)
        $pemiliks = Pemilik::with('user')->get();
        $ras_hewans = RasHewan::with('jenis')->get();

        return view('admin.pet.edit', compact('pet', 'pemiliks', 'ras_hewans'));
    }

    /**
     * UPDATE DATA KE DATABASE (Baru Ditambahkan)
     */
    public function update(Request $request, $id)
    {
        // Validasi sama seperti store
        $request->validate([
            'nama'          => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:J,B',
            'idpemilik'     => 'required|exists:pemilik,idpemilik',
            'idras_hewan'   => 'required|exists:ras_hewan,idras_hewan',
            'warna_tanda'   => 'nullable|string|max:45',
            'tanggal_lahir' => 'nullable|date',
        ]);

        try {
            $pet = Pet::findOrFail($id);
            
            // Update data
            $pet->update([
                'nama'          => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'idpemilik'     => $request->idpemilik,
                'idras_hewan'   => $request->idras_hewan,
                'warna_tanda'   => $request->warna_tanda,
                'tanggal_lahir' => $request->tanggal_lahir,
            ]);

            return redirect()->route('admin.pet.index')->with('success', 'Data Hewan berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    /**
     * HAPUS DATA (Baru Ditambahkan)
     */
    public function destroy($id)
    {
        try {
            $pet = Pet::findOrFail($id);
            $pet->delete();

            return redirect()->route('admin.pet.index')->with('success', 'Data Hewan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }
}