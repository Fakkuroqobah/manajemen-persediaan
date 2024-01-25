<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginKasirController;
use App\Http\Controllers\KasirBarangController;
use App\Http\Controllers\KasirCustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\KasirBarangKeluarController;
use App\Http\Controllers\KasirReturController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirDashboardController;

Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'viewLogin'])->name('home');
    Route::post('/', [LoginController::class, 'login'])->name('login');

    Route::get('/cashier', [LoginKasirController::class, 'viewLogin'])->name('cashier');
    Route::post('/cashier', [LoginKasirController::class, 'login'])->name('cashier_login');
});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/cashier/logout', [LoginKasirController::class, 'logout'])->name('cashier_logout');

Route::resource('barang', BarangController::class);
Route::resource('customer', CustomerController::class);
Route::resource('retur', ReturController::class);

// Route::middleware(['auth:kasir'])->group(function () {
    Route::get('/cashier/dashboard', [KasirDashboardController::class, 'index'])->name('cashier_dashboard');
    Route::get('/cashier/barang', [KasirBarangController::class, 'index'])->name('cashier_barang');
    Route::get('/cashier/customer', [KasirCustomerController::class, 'index'])->name('cashier_customer');
    Route::resource('/cashier/jual', KasirBarangKeluarController::class);
    Route::get('/cashier/retur', [KasirReturController::class, 'index'])->name('cashier_retur');
    Route::get('cashier/penjualan/nota/{id}/{jumlah}', [BarangKeluarController::class, 'nota'])->name('cashier_nota');
// });

Route::middleware(['auth:web'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('download', [LaporanController::class, 'download'])->name('download');
    Route::get('/penjualan/nota/{id}/{jumlah}', [BarangKeluarController::class, 'nota'])->name('nota');

    Route::resource('supplier', SupplierController::class);
    Route::resource('barang-masuk', BarangMasukController::class);
    Route::resource('penjualan', BarangKeluarController::class);
    Route::resource('laporan', LaporanController::class);
    Route::resource('admin', AdminController::class);
    Route::resource('kasir', KasirController::class);
});