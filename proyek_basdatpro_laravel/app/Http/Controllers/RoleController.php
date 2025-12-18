<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleController extends Controller
{
    protected $table = 'role';
    protected $pk = 'idrole';

    protected function ensureAdmin()
    {
        $role = session('user.nama_role') ?? null;
        if (!in_array($role, ['Super Admin', 'Superadmin'])) {
            return redirect()->route('dashboard')->with('error', 'Hanya Super Admin yang boleh akses.')->send();
        }
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $page = (int) $request->get('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        $totalRow = DB::select("SELECT COUNT(*) AS cnt FROM `{$this->table}`");
        $total = $totalRow[0]->cnt ?? 0;

        $rows = DB::select("SELECT * FROM `{$this->table}` ORDER BY `{$this->pk}` ASC LIMIT ? OFFSET ?", [$perPage, $offset]);

        $paginator = new LengthAwarePaginator($rows, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('crud.role.index', [
            'rows' => $paginator
        ]);
    }

    public function create()
    {
        $this->ensureAdmin();
        return view('crud.role.create');
    }

    public function store(Request $r)
    {
        $this->ensureAdmin();
        $r->validate(['nama_role' => 'required|string|max:100']);

        $maxRow = DB::select("SELECT MAX(`{$this->pk}`) AS maxid FROM `{$this->table}`");
        $newId = ($maxRow[0]->maxid ?? 0) + 1;

        DB::insert("INSERT INTO `{$this->table}` (idrole, nama_role) VALUES (?, ?)", [
            $newId, $r->nama_role
        ]);

        return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function show($id)
    {
        $this->ensureAdmin();
        return redirect()->route('role.edit', $id);
    }

    public function edit($id)
    {
        $this->ensureAdmin();
        $data = DB::select("SELECT * FROM `{$this->table}` WHERE `{$this->pk}` = ? LIMIT 1", [$id]);
        if (!$data) return back()->with('error', 'Data tidak ditemukan');
        
        return view('crud.role.edit', ['item' => $data[0]]);
    }

    public function update(Request $r, $id)
    {
        $this->ensureAdmin();
        $r->validate(['nama_role' => 'required|string|max:100']);

        DB::update("UPDATE `{$this->table}` SET nama_role = ? WHERE `{$this->pk}` = ?", [$r->nama_role, $id]);

        return redirect()->route('role.index')->with('success', 'Role berhasil diupdate');
    }

    public function destroy($id)
    {
        $this->ensureAdmin();
        
        // 1. Cek apakah Role ini Role Bawaan (ID 1-5)? Jangan dihapus biar sistem gak rusak.
        if ($id <= 5) {
            return back()->with('error', 'Gagal: Role bawaan sistem tidak boleh dihapus.');
        }

        // 2. Cek apakah Role sedang dipakai oleh User?
        $used = DB::select("SELECT COUNT(*) as cnt FROM user WHERE idrole = ?", [$id]);
        if (($used[0]->cnt ?? 0) > 0) {
            return back()->with('error', 'Gagal Hapus: Masih ada User yang menjabat role ini. Pindahkan user dulu.');
        }

        // 3. Hapus Permanen
        DB::delete("DELETE FROM `{$this->table}` WHERE `{$this->pk}` = ?", [$id]);
        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus permanen');
    }
}