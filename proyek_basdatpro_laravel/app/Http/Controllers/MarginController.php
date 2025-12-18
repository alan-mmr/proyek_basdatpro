<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class MarginController extends Controller
{
    protected $table = 'margin_penjualan';
    protected $pk = 'idmargin_penjualan';

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

        $whereSql = "";
        $params = [];

        if ($status === '1' || $status === '0') {
            $whereSql = "WHERE `status` = ?";
            $params[] = $status;
        }

        $totalRow = DB::select("SELECT COUNT(*) AS cnt FROM `{$this->table}` {$whereSql}", $params);
        $total = $totalRow[0]->cnt ?? 0;

        // Urutkan yang Aktif paling atas
        $rows = DB::select("SELECT * FROM `{$this->table}` {$whereSql} ORDER BY status DESC, `{$this->pk}` DESC LIMIT ? OFFSET ?", array_merge($params, [$perPage, $offset]));

        $paginator = new LengthAwarePaginator($rows, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('crud.margin.index', [
            'rows' => $paginator,
            'status' => $status
        ]);
    }

    public function create()
    {
        $this->ensureAdmin();
        return view('crud.margin.create');
    }

    public function store(Request $r)
    {
        $this->ensureAdmin();
        $r->validate([
            'persen' => 'required|numeric|min:0',
            'status' => 'required|in:0,1'
        ]);

        DB::beginTransaction();
        try {
            // Single Active Rule: Jika user set Aktif, matikan yang lain
            if ($r->status == 1) {
                DB::update("UPDATE `{$this->table}` SET status = 0");
            }

            $maxRow = DB::select("SELECT MAX(`{$this->pk}`) AS maxid FROM `{$this->table}`");
            $newId = ($maxRow[0]->maxid ?? 0) + 1;
            $iduser = session('user.iduser') ?? 1;

            DB::insert("
                INSERT INTO `{$this->table}` (idmargin_penjualan, created_at, persen, status, iduser, updated_at) 
                VALUES (?, NOW(), ?, ?, ?, NOW())
            ", [$newId, $r->persen, $r->status, $iduser]);

            DB::commit();
            return redirect()->route('margin.index')->with('success', 'Margin baru berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $this->ensureAdmin();
        $item = DB::select("SELECT * FROM `{$this->table}` WHERE `{$this->pk}` = ? LIMIT 1", [$id]);
        if (!$item) return back()->with('error', 'Not found');
        return view('crud.margin.edit', ['item' => $item[0]]);
    }

    public function update(Request $r, $id)
    {
        $this->ensureAdmin();
        $r->validate([
            'persen' => 'required|numeric|min:0',
            'status' => 'required|in:0,1'
        ]);

        DB::beginTransaction();
        try {
            if ($r->status == 1) {
                DB::update("UPDATE `{$this->table}` SET status = 0 WHERE `{$this->pk}` != ?", [$id]);
            }

            $iduser = session('user.iduser') ?? 1;

            DB::update("
                UPDATE `{$this->table}` 
                SET persen = ?, status = ?, iduser = ?, updated_at = NOW() 
                WHERE `{$this->pk}` = ?
            ", [$r->persen, $r->status, $iduser, $id]);

            DB::commit();
            return redirect()->route('margin.index')->with('success', 'Margin berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // Tidak ada fitur delete agar history transaksi aman DAN TRANS. Cukup non-aktifkan saja.
}