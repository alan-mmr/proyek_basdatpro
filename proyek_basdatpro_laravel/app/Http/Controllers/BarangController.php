<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

// cek role 

class BarangController extends Controller
{
    protected $table = 'barang';
    protected $pk = 'idbarang';

    protected function ensureAdmin()
    {
        $role = session('user.nama_role') ?? null;
        if (!in_array($role, ['Super Admin', 'Superadmin', 'Admin'])) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized')->send();
        }
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $status = $request->get('status', 'all');
        $page = (int) $request->get('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        // view
        $baseQuery = "SELECT * FROM view_barang_satuan";

        $whereSql = "";
        $params = [];

        if ($status === '1' || $status === '0') {
            $whereSql = "WHERE status = ?";
            $params[] = $status;
        }

        $countSql = "SELECT COUNT(*) AS cnt FROM view_barang_satuan " . $whereSql;
        $totalRow = DB::select($countSql, $params);
        $total = $totalRow[0]->cnt ?? 0;

        $finalSql = $baseQuery . " " . $whereSql . " ORDER BY idbarang DESC LIMIT ? OFFSET ?";
        $finalParams = array_merge($params, [$perPage, $offset]);
        
        $rows = DB::select($finalSql, $finalParams);

        $paginator = new LengthAwarePaginator($rows, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('crud.barang.index', [
            'rows' => $paginator,
            'status' => $status
        ]);
    }

    // loc createnya

    public function create()
    {
        $this->ensureAdmin();
        $satuan = DB::select("SELECT * FROM satuan WHERE status = 1 ORDER BY nama_satuan ASC");
        return view('crud.barang.create', compact('satuan'));
    }

    public function store(Request $r)
    {
        $this->ensureAdmin();
        $r->validate([
            'nama' => 'required|string',
            'jenis' => 'required|string',
            'idsatuan' => 'required|integer',
            'harga' => 'nullable|numeric',
            'status' => 'nullable|in:0,1'
        ]);

        $maxRow = DB::select("SELECT MAX(idbarang) AS maxid FROM barang");
        $newId = ($maxRow[0]->maxid ?? 0) + 1;

        DB::insert("INSERT INTO barang (idbarang, jenis, nama, idsatuan, status, harga) VALUES (?, ?, ?, ?, ?, ?)", [
            $newId, $r->jenis, $r->nama, $r->idsatuan, $r->status ?? 1, $r->harga ?? 0
        ]);

        return redirect()->route('barang.index')->with('success','Barang berhasil ditambahkan');
    }

    public function show($id)
    {
        $this->ensureAdmin();
        return redirect()->route('barang.edit', $id);
    }

    public function edit($id)
    {
        $this->ensureAdmin();
        $items = DB::select("SELECT * FROM barang WHERE idbarang = ? LIMIT 1", [$id]);
        if (!$items) return redirect()->route('barang.index')->with('error','Data tidak ditemukan');
        
        $item = $items[0];
        $satuan = DB::select("SELECT * FROM satuan WHERE status = 1 ORDER BY nama_satuan ASC");
        
        return view('crud.barang.edit', compact('item','satuan'));
    }

    public function update(Request $r, $id)
    {
        $this->ensureAdmin();
        $r->validate([
            'nama' => 'required|string',
            'jenis' => 'required|string',
            'idsatuan' => 'required|integer',
            'harga' => 'nullable|numeric',
            'status' => 'nullable|in:0,1'
        ]);

        DB::update("UPDATE barang SET jenis=?, nama=?, idsatuan=?, status=?, harga=? WHERE idbarang=?", [
            $r->jenis, $r->nama, $r->idsatuan, $r->status ?? 1, $r->harga ?? 0, $id
        ]);

        return redirect()->route('barang.index')->with('success','Barang berhasil diperbarui');
    }

    // hard delete
    public function destroy($id)
    {
        $this->ensureAdmin();
        
        try {
            // Langsung hapus dari database
            DB::delete("DELETE FROM barang WHERE idbarang = ?", [$id]);
            
            return redirect()->route('barang.index')->with('success','Barang berhasil dihapus permanen.');
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangkap error jika barang sudah dipakai di transaksi (Foreign Key Constraint nya jadi manis bahasanya)
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal Hapus: Barang ini sudah ada di riwayat transaksi (Pengadaan/Penjualan/Stok). Silakan non-aktifkan saja lewat Edit.');
            }
            return back()->with('error', 'Gagal Hapus: ' . $e->getMessage());
        }
    }
}