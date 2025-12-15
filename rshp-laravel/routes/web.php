<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================================================
// --- IMPORT SEMUA CONTROLLER ---
// ==========================================================

use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController; // <--- Controller Profile (Modul 13)

// (Admin Controllers)
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\JenisHewanController;
use App\Http\Controllers\Admin\PemilikController;
use App\Http\Controllers\Admin\RasHewanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\KategoriKlinisController;
use App\Http\Controllers\Admin\KodeTindakanTerapiController;
use App\Http\Controllers\Admin\PetController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PendaftaranController;


// (Role Controllers)
use App\Http\Controllers\Resepsionis\DashboardResepsionisController;
use App\Http\Controllers\Dokter\DashboardDokterController;
use App\Http\Controllers\Perawat\DashboardPerawatController;
use App\Http\Controllers\Pemilik\DashboardPemilikController;


// ==========================================================
// --- RUTE PUBLIK (BISA DIAKSES TANPA LOGIN) ---
// ==========================================================
Route::get('/', [PageController::class, 'showHome'])->name('home');
Route::get('/layanan', [PageController::class, 'showLayanan'])->name('layanan');
Route::get('/visimisi', [PageController::class, 'showVisiMisi'])->name('visimisi');
Route::get('/struktur', [PageController::class, 'showStruktur'])->name('struktur');
Route::get('/cek-koneksi', [PageController::class, 'cekKoneksi'])->name('site.cek-koneksi');

// --- AUTHENTICATION ROUTES (Login, Register, Reset Pass) ---
Auth::routes();


// ==========================================================
// --- RUTE GLOBAL (WAJIB LOGIN DULU) ---
// ==========================================================
Route::middleware(['auth'])->group(function () {
    
    // 1. Dashboard Redirect (Menentukan user dilempar ke mana)
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard');

    // 2. FITUR PROFILE (MODUL 13)
    // Ditaruh disini supaya Dokter, Perawat, Admin semua bisa akses
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');     // Tampilkan Form
    
    // --- TAMBAHKAN BARIS INI (Route Password) ---
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    // --------------------------------------------
    
    // PERBAIKAN DISINI: Pakai 'match' biar bisa terima POST dan PATCH sekaligus
    Route::match(['put', 'patch', 'post'], '/profile', [ProfileController::class, 'update'])->name('profile.update'); 
});


// ==========================================================
// --- GRUP RUTE SPESIFIK ROLE (DILINDUNGI MIDDLEWARE) ---
// ==========================================================

// --- 1. GRUP ADMIN (Hanya user dengan role Administrator) ---
Route::middleware(['isAdministrator'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    // --- DATA MASTER (MASS UPGRADE KE RESOURCE) ---
    // Semua route di bawah ini otomatis punya fitur: Index, Create, Store, Show, Edit, Update, Destroy
    
    Route::resource('jenis-hewan', JenisHewanController::class);
    Route::resource('pemilik', PemilikController::class);
    Route::resource('ras-hewan', RasHewanController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('kategori-klinis', KategoriKlinisController::class);
    Route::resource('kode-tindakan', KodeTindakanTerapiController::class);
    Route::resource('pet', PetController::class);
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    
    // Pendaftaran (Masih manual dulu karena mungkin logic-nya custom/transaksi)
    Route::get('/pendaftaran',[PendaftaranController::class, 'index'])->name('pendaftaran.index');

}); 

// --- 2. GRUP RESEPSIONIS ---
Route::middleware(['isResepsionis'])->prefix('resepsionis')->name('resepsionis.')->group(function () {
    Route::get('/dashboard', [DashboardResepsionisController::class, 'index'])->name('dashboard');
});

// --- 3. GRUP DOKTER ---
Route::middleware(['isDokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DashboardDokterController::class, 'index'])->name('dashboard');
});

// --- 4. GRUP PERAWAT ---
Route::middleware(['isPerawat'])->prefix('perawat')->name('perawat.')->group(function () {
    Route::get('/dashboard', [DashboardPerawatController::class, 'index'])->name('dashboard');
});

// --- 5. GRUP PEMILIK ---
Route::middleware(['isPemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {
    Route::get('/dashboard', [DashboardPemilikController::class, 'index'])->name('dashboard');
});