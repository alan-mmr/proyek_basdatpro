<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PenjualanController extends Controller
{
    protected function ensurePermission()
    {
        $role = session('user.nama_role') ?? null;
        if (!in_array($role, ['Super Admin', 'Superadmin', 'Admin', 'Staff'])) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized')->send();
        }
    }

    public function index(Request $request)
    {
        $this->ensurePermission();

        $page = (int) $request->get('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        $totalRow = DB::select("SELECT COUNT(*) AS cnt FROM penjualan");
        $total = $totalRow[0]->cnt ?? 0;

        // REVISI: Hapus join customer
        $rows = DB::select("
            SELECT p.*, u.username as nama_kasir
            FROM penjualan p
            LEFT JOIN user u ON u.iduser = p.iduser
            ORDER BY p.idpenjualan DESC
            LIMIT ? OFFSET ?
        ", [$perPage, $offset]);

        $paginator = new LengthAwarePaginator($rows, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('crud.penjualan.index', ['rows' => $paginator]);
    }

    public function create()
    {
        $this->ensurePermission();

        // REVISI: Hapus query customer
        // Ambil barang aktif + stok
        $barangs = DB::select("
            SELECT b.idbarang, b.nama, b.harga,
            (
                SELECT stock FROM kartu_stok ks 
                WHERE ks.idbarang = b.idbarang 
                ORDER BY ks.idkartu_stok DESC LIMIT 1
            ) as stok_saat_ini
            FROM barang b
            WHERE b.status = 1
            ORDER BY b.nama ASC
        ");

        return view('crud.penjualan.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $this->ensurePermission();

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.idbarang' => 'required|integer',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $maxRow = DB::select("SELECT MAX(idpenjualan) AS maxid FROM penjualan");
            $newId = ($maxRow[0]->maxid ?? 0) + 1;
            $iduser = session('user.iduser') ?? 1;
            
            // Ambil Margin Aktif
            $marginRow = DB::select("SELECT idmargin_penjualan FROM margin_penjualan WHERE status = 1 LIMIT 1");
            $idMargin = $marginRow[0]->idmargin_penjualan ?? NULL;

            // REVISI: Hapus idpelanggan dari insert
            DB::insert("
                INSERT INTO penjualan 
                (idpenjualan, created_at, subtotal_nilai, ppn, total_nilai, iduser, idmargin_penjualan)
                VALUES (?, NOW(), 0, 0, 0, ?, ?)
            ", [$newId, $iduser, $idMargin]);

            // Detail
            $maxDet = DB::select("SELECT MAX(iddetail_penjualan) AS maxid FROM detail_penjualan");
            $nextDetId = ($maxDet[0]->maxid ?? 0) + 1;

            foreach ($request->items as $item) {
                $barang = DB::select("SELECT harga FROM barang WHERE idbarang = ? LIMIT 1", [$item['idbarang']]);
                $harga = $barang[0]->harga ?? 0;
                $qty = $item['jumlah'];
                $sub = $harga * $qty;

                DB::insert("
                    INSERT INTO detail_penjualan 
                    (iddetail_penjualan, harga_satuan, jumlah, subtotal, penjualan_idpenjualan, idbarang)
                    VALUES (?, ?, ?, ?, ?, ?)
                ", [
                    $nextDetId, $harga, $qty, $sub, $newId, $item['idbarang']
                ]);
                $nextDetId++;
            }

            // PENTING: Hapus hitungan manual PHP di sini, karena Trigger DB yang akan update total.
            
            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil. ID: ' . $newId);

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1644) { 
                return back()->with('error', 'Gagal: ' . $e->errorInfo[2])->withInput();
            }
            return back()->with('error', 'Database Error: ' . $e->getMessage())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'System Error: ' . $e->getMessage())->withInput();
        }
    }
    
    public function show($id)
    {
        $this->ensurePermission();

        // REVISI: Hapus join customer
        $sales = DB::select("
            SELECT p.*, u.username as nama_kasir
            FROM penjualan p
            LEFT JOIN user u ON u.iduser = p.iduser
            WHERE p.idpenjualan = ?
            LIMIT 1
        ", [$id]);

        if (empty($sales)) {
            return redirect()->route('penjualan.index')->with('error', 'Transaksi tidak ditemukan');
        }
        $sale = $sales[0];

        $details = DB::select("
            SELECT dp.*, b.nama as nama_barang
            FROM detail_penjualan dp
            LEFT JOIN barang b ON b.idbarang = dp.idbarang
            WHERE dp.penjualan_idpenjualan = ?
        ", [$id]);

        return view('crud.penjualan.show', compact('sale', 'details'));
    }
}