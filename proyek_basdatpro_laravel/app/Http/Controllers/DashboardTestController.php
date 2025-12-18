<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardTestController extends Controller
{
    public function index()
    {
        // gunakan nama koneksi yang sama (mysql) tapi baca nama db saat ini untuk info
        $db = config('database.connections.mysql.database');

        $barang = [];

        // kalau view ada, ambil sample 3 baris
        $exists = DB::select(
            'SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?',
            [$db, 'view_barang_satuan']
        );

        if (!empty($exists)) {
            $barang = DB::select('SELECT * FROM `view_barang_satuan` LIMIT 3');
        }

        // tampilkan view test (buat file resources/views/dashboard_test.blade.php)
        return view('dashboard_test', compact('barang','db'));
    }
}
