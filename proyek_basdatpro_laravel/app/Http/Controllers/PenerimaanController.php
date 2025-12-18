<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PenerimaanController extends Controller
{
    protected function ensurePermission()
    {
        $role = session('user.nama_role') ?? null;
        if (!in_array($role, ['Super Admin', 'Superadmin', 'Admin', 'Gudang'])) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized')->send();
        }
    }

    public function index(Request $request)
    {
        $this->ensurePermission();

        $page = (int) $request->get('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        // view
        $totalRow = DB::select("SELECT COUNT(*) AS cnt FROM view_penerimaan_pengadaan_user");
        $total = $totalRow[0]->cnt ?? 0;

        $rows = DB::select("
            SELECT * FROM view_penerimaan_pengadaan_user
            ORDER BY idpenerimaan DESC
            LIMIT ? OFFSET ?
        ", [$perPage, $offset]);

        $paginator = new LengthAwarePaginator($rows, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);

        return view('crud.penerimaan.index', ['rows' => $paginator]);
    }

    public function create()
    {
        $this->ensurePermission();

        // 1. Ambil Semua Pengadaan
        $rawPengadaans = DB::select("
            SELECT p.idpengadaan, p.timestamp, p.total_nilai, v.nama_vendor
            FROM pengadaan p
            LEFT JOIN vendor v ON v.idvendor = p.vendor_idvendor
            ORDER BY p.idpengadaan DESC
            LIMIT 100
        ");

        $pengadaans = []; // Array penampung hasil filter

        // 2. Filter: Hanya ambil yang masih punya sisa barang
        foreach ($rawPengadaans as $p) {
            // Ambil detail barang & status terimanya
            $p->details = DB::select("
                SELECT 
                    dp.idbarang, 
                    b.nama AS nama_barang, 
                    dp.jumlah AS qty_pesan,
                    (
                        SELECT COALESCE(SUM(dpr.jumlah_terima), 0)
                        FROM detail_penerimaan dpr
                        JOIN penerimaan pr ON pr.idpenerimaan = dpr.idpenerimaan
                        WHERE pr.idpengadaan = dp.idpengadaan AND dpr.barang_idbarang = dp.idbarang
                    ) AS qty_sudah_terima
                FROM detail_pengadaan dp
                LEFT JOIN barang b ON b.idbarang = dp.idbarang
                WHERE dp.idpengadaan = ?
            ", [$p->idpengadaan]);

            // Cek apakah PO ini masih punya 'utang' barang?
            $masihButuh = false;
            foreach ($p->details as $d) {
                if ($d->qty_pesan > $d->qty_sudah_terima) {
                    $masihButuh = true; 
                    break; // Ada 1 aja yang belum lunas, berarti PO ini valid
                }
            }

            // Jika masih butuh barang, masukkan ke list dropdown
            if ($masihButuh) {
                $pengadaans[] = $p;
            }
        }

        return view('crud.penerimaan.create', compact('pengadaans'));
    }
      

    public function store(Request $request)
    {
        $this->ensurePermission();

        $request->validate([
            'idpengadaan' => 'required|integer',
            'items' => 'required|array|min:1',
        ]);

        $idpengadaan = $request->idpengadaan;
        $iduser = session('user.iduser') ?? 1;

        DB::beginTransaction();
        try {
            $maxId = DB::select("SELECT MAX(idpenerimaan) AS maxid FROM penerimaan");
            $newId = ($maxId[0]->maxid ?? 0) + 1;

            DB::insert("
                INSERT INTO penerimaan (idpenerimaan, created_at, status, idpengadaan, iduser)
                VALUES (?, NOW(), '1', ?, ?)
            ", [$newId, $idpengadaan, $iduser]);

            $maxDet = DB::select("SELECT MAX(iddetail_penerimaan) AS maxid FROM detail_penerimaan");
            $nextDetId = ($maxDet[0]->maxid ?? 0) + 1;
            $itemsInserted = 0;

            foreach ($request->items as $item) {
                $qtyTerima = (int)$item['jumlah_terima'];
                
                if ($qtyTerima > 0) {
                    DB::insert("
                        INSERT INTO detail_penerimaan 
                        (iddetail_penerimaan, idpenerimaan, barang_idbarang, jumlah_terima, harga_satuan_terima, sub_total_terima)
                        VALUES (?, ?, ?, ?, 0, 0) 
                    ", [
                        $nextDetId, $newId, $item['idbarang'], $qtyTerima
                    ]);
                    // Trigger database akan mengisi harga & subtotal otomatis
                    $nextDetId++;
                    $itemsInserted++;
                }
            }

            if ($itemsInserted == 0) {
                throw new \Exception("Tidak ada barang yang diterima (jumlah 0 semua).");
            }

            DB::commit();
            return redirect()->route('penerimaan.show', $newId)->with('success', 'Penerimaan berhasil disimpan. ID: ' . $newId);

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
        
        // Ambil Header dari View
        $header = DB::select("SELECT * FROM view_penerimaan_pengadaan_user WHERE idpenerimaan = ? LIMIT 1", [$id]);
        
        if (!$header) return redirect()->route('penerimaan.index');

        // Ambil Detail dari View Detail
        $details = DB::select("SELECT * FROM view_detail_penerimaan_lengkap WHERE idpenerimaan = ?", [$id]);

        return view('crud.penerimaan.show', ['item' => $header[0], 'details' => $details]);
    }
}