<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\TestSessionController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\MarginController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\PenjualanController; 

use App\Http\Controllers\DashboardTestController;
use App\Http\Controllers\LandingController;

use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.post');
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

// landing page (public)
Route::get('/', [LandingController::class, 'index'])->name('landing');

// dashboard setelah login
Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
Route::get('/dashboard-test', [DashboardTestController::class, 'index'])->name('dashboard.test');

// Module dynamic views
Route::get('/modules/{view}', [ModuleController::class,'show'])->name('modules.show');
Route::get('/modules/{view}/full', [ModuleController::class,'full'])->name('modules.full');

// CRUD resource routes
Route::resource('barang', BarangController::class);
Route::resource('vendor', VendorController::class);
Route::resource('satuan', SatuanController::class);

// DEV helper 
Route::get('/set-session/{iduser}', [TestSessionController::class,'setSession']);
Route::get('/clear-session', [TestSessionController::class,'clear']);

// CRUD pengadaan (tanpa edit/update/destroy  transaksi immutable)
Route::resource('pengadaan', PengadaanController::class)->except(['edit','update','destroy']);

// Endpoint trigger penerimaan
Route::post('/penerimaan/receive', [PenerimaanController::class, 'store'])->name('penerimaan.receive');


// Modul Penjualan (Transaksi Keluar) - index & create & store only
Route::resource('penjualan', PenjualanController::class)->except(['edit', 'update', 'destroy']);

// index/list + resource
Route::resource('margin', MarginController::class);
Route::resource('role', RoleController::class);

// Modul Penerimaan
Route::get('/penerimaan', [PenerimaanController::class, 'index'])->name('penerimaan.index'); 
Route::get('/penerimaan/create', [PenerimaanController::class, 'create'])->name('penerimaan.create');
Route::post('/penerimaan/receive', [PenerimaanController::class, 'store'])->name('penerimaan.receive');
Route::get('/penerimaan/{id}', [PenerimaanController::class, 'show'])->name('penerimaan.show'); 


// CRUD User (Hanya untuk Super Admin, dicek di controller)
Route::resource('user', UserController::class);