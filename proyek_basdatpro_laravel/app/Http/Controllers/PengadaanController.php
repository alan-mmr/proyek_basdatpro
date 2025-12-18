<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PengadaanController extends Controller
{
    protected function ensurePermission()
    {
        $role = session('user.nama_role') ?? null;
        if (!in_array($role, ['Super Admin', 'Superadmin', 'Admin'])) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized')->send();
        }
    }

    public function index(Request $request)
    {
        $this->ensurePermission();

        $page = (int) $request->get('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        // Ambil data dari View Database
        $totalRow = DB::select("SELECT COUNT(*) AS cnt FROM view_pengadaan_vendor_user");
        $total = $totalRow[0]->cnt ?? 0;

        $rows = DB::select("
            SELECT * FROM view_pengadaan_vendor_user
            ORDER BY idpengadaan DESC
            LIMIT ? OFFSET ?
        ", [$perPage, $offset]);

        $paginator = new LengthAwarePaginator($rows, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('crud.pengadaan.index', ['rows' => $paginator]);
    }

    public function create()
    {
        $this->ensurePermission();

        // Ambil Vendor Aktif
        $vendors = DB::select("SELECT idvendor, nama_vendor FROM vendor WHERE status = '1' ORDER BY nama_vendor ASC");
        
        // Ambil Barang Aktif
        $barangs = DB::select("SELECT idbarang, nama, harga FROM barang WHERE status = 1 ORDER BY nama ASC");

        return view('crud.pengadaan.create', compact('vendors', 'barangs'));
    }

    public function store(Request $r)
    {
        $this->ensurePermission();  // Validasi: Pastikan Vendor dipilih dan minimal ada 1 barang.

        $r->validate([
            'vendor_id' => 'required|integer',
            'items' => 'required|array|min:1',
            'items.*.idbarang' => 'required|integer',
            'items.*.harga_satuan' => 'required|numeric|min:0',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat ID Pengadaan Baru
            $maxRow = DB::select("SELECT MAX(idpengadaan) AS maxid FROM pengadaan");
            $newId = ($maxRow[0]->maxid ?? 0) + 1;
            $iduser = session('user.iduser') ?? 1;

            // 2. Insert Header (Total 0 dulu, Trigger DB akan update)
            DB::insert("
                INSERT INTO pengadaan 
                (idpengadaan, timestamp, user_iduser, status, vendor_idvendor, subtotal_nilai, ppn, total_nilai)
                VALUES (?, NOW(), ?, '0', ?, 0, 0, 0)
            ", [$newId, $iduser, $r->vendor_id]);

            // 3. Insert Detail Items
            $maxDet = DB::select("SELECT MAX(iddetail_pengadaan) AS maxid FROM detail_pengadaan");
            $nextDetId = ($maxDet[0]->maxid ?? 0) + 1;

            foreach ($r->items as $item) {
                DB::insert("
                    INSERT INTO detail_pengadaan 
                    (iddetail_pengadaan, harga_satuan, jumlah, sub_total, idbarang, idpengadaan)
                    VALUES (?, ?, ?, 0, ?, ?)
                ", [
                    $nextDetId, 
                    $item['harga_satuan'], 
                    $item['jumlah'], 
                    $item['idbarang'], 
                    $newId
                ]);
                $nextDetId++;
            }

            DB::commit();
            return redirect()->route('pengadaan.index')->with('success', 'PO berhasil dibuat (ID: '.$newId.')');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $this->ensurePermission();
        
        $header = DB::select("SELECT * FROM view_pengadaan_vendor_user WHERE idpengadaan = ? LIMIT 1", [$id]);
        
        if (!$header) return redirect()->route('pengadaan.index');

        $details = DB::select("SELECT * FROM view_detail_pengadaan_lengkap WHERE idpengadaan = ?", [$id]);

        return view('crud.pengadaan.show', ['item' => $header[0], 'details' => $details]);
    }
}