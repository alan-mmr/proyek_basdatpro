<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;

class ModuleController extends Controller
{
    // cek view exists
    public function checkViewExists($view)
    {
        $db = config('database.connections.mysql.database');
        $r = DB::select(
            'SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?',
            [$db, $view]
        );
        return !empty($r);
    }

    // buat rute dari setiap web route

    private function makeLink($route, $label)
    {
        if (Route::has($route)) {
            return ['url' => route($route), 'label' => $label];
        }
        return null;
    }

    //Halaman Daftar Modul
    // ngambil daftar semua tabel/view yang ada di database dan menampilkannya dalam bentuk list.

    public function index(Request $request)
    {
        $page = (int) $request->get('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        $dbNameRow = DB::select('SELECT DATABASE() AS dbname');
        $dbName = $dbNameRow[0]->dbname ?? null;

        $rows = DB::select(
            'SELECT TABLE_NAME, TABLE_TYPE FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? ORDER BY TABLE_NAME LIMIT ? OFFSET ?',
            [$dbName, $perPage, $offset]
        );

        $totalRow = DB::select('SELECT COUNT(*) AS cnt FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ?', [$dbName]);
        $total = $totalRow[0]->cnt ?? 0;

        $paginator = new LengthAwarePaginator($rows, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);

        return view('modules.index', ['rows' => $paginator, 'dbName' => $dbName]);
    }

    // 3 dari atas aja

    public function show($view)
    {
        if (!$this->checkViewExists($view)) {
            abort(404, 'View not found');
        }

        $rows = DB::select("SELECT * FROM `" . $view . "` LIMIT 3");
        $cols = DB::select("SHOW COLUMNS FROM `" . $view . "`");
        $cols = array_map(fn($c) => $c->Field, $cols);

        // logika tombol shotcut

        $extraLinks = [];

        // 1. Barang & Satuan 
        if ($view === 'view_barang_satuan' || $view === 'view_kartu_stok_barang') {
            // Shortcut Barang
            $extraLinks[] = $this->makeLink('barang.index', 'List Barang (Tabel)');
            $extraLinks[] = $this->makeLink('barang.create', '+ Tambah Barang Baru');
            
            // Shortcut Satuan
            $extraLinks[] = $this->makeLink('satuan.index', 'List Satuan (Tabel)');
            $extraLinks[] = $this->makeLink('satuan.create', '+ Tambah Satuan Baru');
        }

        // 2. Vendor
        if ($view === 'view_vendor_status') {
            $extraLinks[] = $this->makeLink('vendor.index', 'List Vendor');
            $extraLinks[] = $this->makeLink('vendor.create', '+ Tambah Vendor');
        }

        // 3. Pengadaan
        if (in_array($view, ['view_detail_pengadaan_lengkap', 'view_pengadaan_vendor_user'])) {
            $extraLinks[] = $this->makeLink('pengadaan.index', 'List Pengadaan');
            $extraLinks[] = $this->makeLink('pengadaan.create', '+ Buat Pengadaan Baru');
            $extraLinks[] = $this->makeLink('vendor.index', 'List Vendor');
        }

        // 4. Penerimaan
        if (in_array($view, ['view_penerimaan_pengadaan_user', 'view_detail_penerimaan_lengkap'])) {
            $extraLinks[] = $this->makeLink('penerimaan.index', 'List Penerimaan');
            $extraLinks[] = $this->makeLink('penerimaan.create', '+ Buat Penerimaan');
        }

        // 5. Penjualan
        if (in_array($view, ['view_penjualan_margin_user', 'view_detail_penjualan_lengkap', 'view_penjualan_header'])) {
            $extraLinks[] = $this->makeLink('penjualan.index', 'List Penjualan');
            $extraLinks[] = $this->makeLink('penjualan.create', '+ Buat Transaksi Baru');
        }

        // 6. Margin
        if ($view === 'view_penjualan_margin_user') {
            $extraLinks[] = $this->makeLink('margin.index', 'Kelola Margin');
            $extraLinks[] = $this->makeLink('margin.create', '+ Tambah Margin');
        }
        
        // 7. Role/User
        if ($view === 'view_user_role') {
             $extraLinks[] = $this->makeLink('role.index', 'List Role');
             $extraLinks[] = $this->makeLink('role.create', '+ Tambah Role');
             $extraLinks[] = $this->makeLink('user.index', 'List User');
             $extraLinks[] = $this->makeLink('user.create', '+ Tambah User');
        }

        $extraLinks = array_values(array_filter($extraLinks));

        return view('modules.generic', compact('view', 'rows', 'cols', 'extraLinks'));
    }

    public function full(Request $request, $view)
    {
        if (!$this->checkViewExists($view)) {
            abort(404, 'Table/view not found: ' . $view);
        }

        $cols = DB::select("SHOW COLUMNS FROM `{$view}`");
        $colNames = array_map(fn($c) => $c->Field, $cols);
        $hasStatus = in_array('status', $colNames);

        $statusFilter = $request->get('status');
        if ($hasStatus && $statusFilter === null) {
            $statusFilter = '1';
        }

        $page = (int) $request->get('page', 1);
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        $query = "SELECT * FROM `{$view}`";
        $countQuery = "SELECT COUNT(*) AS cnt FROM `{$view}`";
        $params = [];

        if ($hasStatus && $statusFilter !== 'all') {
            $query .= " WHERE `status` = ?";
            $countQuery .= " WHERE `status` = ?";
            $params[] = $statusFilter;
        }

        $query .= " LIMIT ? OFFSET ?";
        $queryParams = array_merge($params, [$perPage, $offset]);

        $totalRow = DB::select($countQuery, $params);
        $total = $totalRow[0]->cnt ?? 0;

        $rows = DB::select($query, $queryParams);

        $paginator = new LengthAwarePaginator($rows, $total, $perPage, $page, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);

        return view('modules.full', [
            'view' => $view,
            'rows' => $paginator,
            'cols' => $colNames,
            'total' => $total,
            'hasStatus' => $hasStatus,
            'currentStatus' => $statusFilter
        ]);
    }
}























