<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Retur;

class KasirDashboardController extends Controller
{
    public function index()
    {
        $data['barang'] = Barang::count();
        $data['customer'] = Customer::count();
        $data['supplier'] = Supplier::count();
        $data['masuk'] = BarangMasuk::count();
        $data['keluar'] = BarangKeluar::count();
        $data['retur'] = Retur::count();

        return view('cashier_dashboard', compact('data'));
    }
}