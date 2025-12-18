<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Cek Login
        if (! session('user')) {
            return redirect()->route('login');
        }

        $role = session('user.nama_role');

        // 2. Ambil Data Statistik Utama
        
        // Hitung Total Omset (Uang Masuk)
        $omsetRow = DB::select("SELECT SUM(total_nilai) as total FROM penjualan");
        $totalOmset = $omsetRow[0]->total ?? 0;

        // Hitung Total Pengeluaran (Belanja)
        // Memanggil function hitung_total_pengadaan
        $data2 = DB::select("SELECT hitung_total_pengadaan() AS total");
        $totalPengadaan = $data2[0]->total;

        // Hitung Jumlah Transaksi Penjualan
     // Memanggil function hitung_total_penjualan
    $data = DB::select("SELECT hitung_total_penjualan() AS total");

    // Untuk mengambil nilai angkanya saja (karena DB::select mengembalikan array)
    $totalPenjualan = $data[0]->total;

        // 3. Ambil 'Minat Pasar' (Barang Terlaris) menggunakan Stored Procedure
        // Parameter NULL, NULL artinya ambil data dari awal sampai sekarang (Semua Waktu)
        $minatPasar = DB::select("CALL sp_minat_pasar(NULL, NULL)");

        // Ambil 5 teratas saja untuk ditampilkan di dashboard
        $top5 = array_slice($minatPasar, 0, 5);

        // Kirim data ke View
        return view('dashboard', compact('totalOmset', 'totalPengadaan', 'totalPenjualan', 'top5', 'role'));
    }
}