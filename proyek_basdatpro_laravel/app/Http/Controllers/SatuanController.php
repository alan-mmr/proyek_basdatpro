<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class SatuanController extends Controller
{
    protected $table = 'satuan';
    protected $pk = 'idsatuan';

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

        $status = $request->get('status', 'all'); // all / 1 / 0
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

        // Gabungkan params untuk LIMIT
        $finalParams = array_merge($params, [$perPage, $offset]);
        $rows = DB::select("SELECT * FROM `{$this->table}` {$whereSql} ORDER BY `{$this->pk}` DESC LIMIT ? OFFSET ?", $finalParams);

        $paginator = new LengthAwarePaginator($rows, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('crud.satuan.index', [
            'rows' => $paginator,
            'status' => $status
        ]);
    }

    public function create()
    {
        $this->ensureAdmin();
        return view('crud.satuan.create');
    }

    public function store(Request $r)
    {
        $this->ensureAdmin();
        $r->validate([
            'nama_satuan' => 'required|string|max:50',
            'status' => 'nullable|in:0,1'
        ]);

        $maxRow = DB::select("SELECT MAX(`{$this->pk}`) AS maxid FROM `{$this->table}`");
        $newId = ($maxRow[0]->maxid ?? 0) + 1;

        DB::insert("INSERT INTO `{$this->table}` (`{$this->pk}`, `nama_satuan`, `status`) VALUES (?, ?, ?)", [
            $newId,
            $r->nama_satuan,
            $r->status ?? 1
        ]);

        return redirect()->route('satuan.index')->with('success','Satuan berhasil ditambahkan');
    }

    public function show($id)
    {
        $this->ensureAdmin();
        return redirect()->route('satuan.edit', $id);
    }

    public function edit($id)
    {
        $this->ensureAdmin();
        $items = DB::select("SELECT * FROM `{$this->table}` WHERE `{$this->pk}` = ? LIMIT 1", [$id]);
        if (!$items) return redirect()->route('satuan.index')->with('error','Data tidak ditemukan');
        return view('crud.satuan.edit', ['item' => $items[0]]);
    }

    public function update(Request $r, $id)
    {
        $this->ensureAdmin();
        $r->validate([
            'nama_satuan' => 'required|string|max:50',
            'status' => 'nullable|in:0,1'
        ]);

        DB::update("UPDATE `{$this->table}` SET `nama_satuan` = ?, `status` = ? WHERE `{$this->pk}` = ?", [
            $r->nama_satuan,
            $r->status ?? 1,
            $id
        ]);

        return redirect()->route('satuan.index')->with('success','Satuan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->ensureAdmin();
        try {
            DB::delete("DELETE FROM `{$this->table}` WHERE `{$this->pk}` = ?", [$id]);
            return redirect()->route('satuan.index')->with('success','Satuan berhasil dihapus permanen');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal Hapus: Satuan ini sedang dipakai oleh Barang lain. Silakan non-aktifkan saja.');
            }
            return back()->with('error', $e->getMessage());
        }
    }
}