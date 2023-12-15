<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\LaporanController;

Route::get('/', [LoginController::class, 'viewLogin'])->name('home');
Route::post('/', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('download', [LaporanController::class, 'download'])->name('download');

Route::resource('barang', BarangController::class);
Route::resource('customer', CustomerController::class);
Route::resource('supplier', SupplierController::class);
Route::resource('barang-masuk', BarangMasukController::class);
Route::resource('penjualan', BarangKeluarController::class);
Route::resource('retur', ReturController::class);
Route::resource('laporan', LaporanController::class);
