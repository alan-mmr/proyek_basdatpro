<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class UserController extends Controller
{
    protected $table = 'user';
    protected $pk = 'iduser';

    protected function ensureAdmin()
    {
        $role = session('user.nama_role') ?? null;
        if (!in_array($role, ['Super Admin', 'Superadmin'])) {
            return redirect()->route('dashboard')->with('error', 'Hanya Super Admin yang boleh mengelola User.')->send();
        }
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $page = (int) $request->get('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        // REVISI: Gunakan VIEW 'view_user_role' agar konsisten dengan aturan proyek
        // View ini sudah berisi join user + role
        $totalRow = DB::select("SELECT COUNT(*) AS cnt FROM view_user_role");
        $total = $totalRow[0]->cnt ?? 0;

        $rows = DB::select("SELECT * FROM view_user_role ORDER BY iduser DESC LIMIT ? OFFSET ?", [$perPage, $offset]);

        $paginator = new LengthAwarePaginator($rows, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('crud.user.index', ['rows' => $paginator]);
    }

    public function create()
    {
        $this->ensureAdmin();
        // Ambil semua role untuk dropdown
        $roles = DB::select("SELECT * FROM role ORDER BY idrole ASC");
        return view('crud.user.create', compact('roles'));
    }

    public function store(Request $r)
    {
        $this->ensureAdmin();
        $r->validate([
            'username' => 'required|string|max:45|unique:user,username',
            'password' => 'required|string|min:3',
            'idrole'   => 'required|integer'
        ]);

        $maxRow = DB::select("SELECT MAX(iduser) AS maxid FROM user");
        $newId = ($maxRow[0]->maxid ?? 0) + 1;

        DB::insert("INSERT INTO user (iduser, username, password, idrole) VALUES (?, ?, ?, ?)", [
            $newId, 
            $r->username, 
            $r->password, // Plain text sesuai sistem saat ini
            $r->idrole
        ]);

        return redirect()->route('user.index')->with('success', 'User baru berhasil dibuat');
    }

    public function edit($id)
    {
        $this->ensureAdmin();
        
        $users = DB::select("SELECT * FROM user WHERE iduser = ? LIMIT 1", [$id]);
        if (!$users) return redirect()->route('user.index')->with('error', 'User tidak ditemukan');
        $item = $users[0];

        $roles = DB::select("SELECT * FROM role ORDER BY idrole ASC");
        
        return view('crud.user.edit', compact('item', 'roles'));
    }

    public function update(Request $r, $id)
    {
        $this->ensureAdmin();
        $r->validate([
            'username' => 'required|string|max:45',
            'idrole'   => 'required|integer'
        ]);

        // Cek apakah password diisi? Kalau kosong, jangan diubah.
        if ($r->filled('password')) {
            DB::update("UPDATE user SET username=?, password=?, idrole=? WHERE iduser=?", [
                $r->username, $r->password, $r->idrole, $id
            ]);
        } else {
            DB::update("UPDATE user SET username=?, idrole=? WHERE iduser=?", [
                $r->username, $r->idrole, $id
            ]);
        }

        return redirect()->route('user.index')->with('success', 'Data User diperbarui');
    }

    public function destroy($id)
    {
        $this->ensureAdmin();

        // 1. Cegah hapus diri sendiri
        if ($id == session('user.iduser')) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        // 2. Cegah hapus jika sudah pernah transaksi (Integritas Data)
        try {
            DB::delete("DELETE FROM user WHERE iduser = ?", [$id]);
            return redirect()->route('user.index')->with('success', 'User berhasil dihapus permanen');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error 1451 = Foreign Key Constraint Fails
            if ($e->errorInfo[1] == 1451) {
                return back()->with('error', 'Gagal Hapus: User ini memiliki riwayat transaksi (Penjualan/Pembelian). Data tidak boleh hilang.');
            }
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }
}