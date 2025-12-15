<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RasHewan;
use App\Models\JenisHewan; // Wajib import buat Dropdown
use Exception;

class RasHewanController extends Controller
{
    public function index()
    {
        // Eager Loading 'jenisHewan' biar query cepat
        $rasHewan = RasHewan::with('jenisHewan')->get();
        return view('admin.ras-hewan.index', compact('rasHewan'));
    }

    public function create()
    {
        // Ambil data Jenis Hewan buat isi Dropdown
        $jenisHewan = JenisHewan::all();
        return view('admin.ras-hewan.create', compact('jenisHewan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_ras' => 'required|string|max:100',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ], [
            'idjenis_hewan.required' => 'Jenis hewan wajib dipilih.',
        ]);

        try {
            RasHewan::create([
                'nama_ras' => $request->nama_ras,
                'idjenis_hewan' => $request->idjenis_hewan,
            ]);

            return redirect()->route('admin.ras-hewan.index')
                ->with('success', 'Ras hewan berhasil ditambahkan.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $rasHewan = RasHewan::findOrFail($id);
        $jenisHewan = JenisHewan::all(); // Buat Dropdown
        return view('admin.ras-hewan.edit', compact('rasHewan', 'jenisHewan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ras' => 'required|string|max:100',
            'idjenis_hewan' => 'required|exists:jenis_hewan,idjenis_hewan',
        ]);

        try {
            $rasHewan = RasHewan::findOrFail($id);
            $rasHewan->update([
                'nama_ras' => $request->nama_ras,
                'idjenis_hewan' => $request->idjenis_hewan,
            ]);

            return redirect()->route('admin.ras-hewan.index')
                ->with('success', 'Ras hewan berhasil diperbarui.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $rasHewan = RasHewan::findOrFail($id);
            $rasHewan->delete();
            return redirect()->route('admin.ras-hewan.index')
                ->with('success', 'Ras hewan berhasil dihapus.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}