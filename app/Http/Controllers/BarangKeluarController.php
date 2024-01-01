<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Customer;
use App\Models\Barang;
use App\Models\Kasir;
use DataTables;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::all();
        $customer = Customer::all();
        $kasir = Kasir::all();

        if($request->ajax()) {
            $data = BarangKeluar::with(['barang', 'customer', 'kasir'])->latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($data) {
                    return '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id_barang_keluar .'">Delete</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('barang_keluar.barang_keluar', compact('barang', 'customer', 'kasir'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'jumlah' => 'required',
            'id_barang' => 'required',
            'id_customer' => 'required',
            'id_kasir' => 'required',
        ]);

        $check = Barang::findOrFail($request->id_barang);
        if($check->stok_barang < $request->jumlah) {
            return $this->res(422, 'Gagal', 'Jumlah yang diminta tidak memenuhi stok saat ini');
        }

        try {
            $data = BarangKeluar::create([
                'tanggal_barang_keluar' => $request->tanggal,
                'jumlah_barang_keluar' => $request->jumlah,
                'id_barang' => $request->id_barang,
                'id_customer' => $request->id_customer,
                'id_kasir' => $request->id_kasir
            ]);

            $data = Barang::findOrFail($request->id_barang);
            $data->update([
                'stok_barang' => $data->stok_barang - $request->jumlah
            ]);

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = BarangKeluar::with(['barang', 'customer'])->findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'jumlah' => 'required',
            'id_barang' => 'required',
            'id_customer' => 'required',
            'id_kasir' => 'required',
        ]);

        $data = BarangKeluar::findOrFail($id);
        try {
            $data->update([
                'tanggal_barang_keluar' => $request->tanggal,
                'jumlah_barang_keluar' => $request->jumlah,
                'id_barang' => $request->id_barang,
                'id_customer' => $request->id_customer,
                'id_kasir' => $request->id_kasir
            ]);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = BarangKeluar::findOrFail($id);
        $data2 = Barang::findOrFail($data->id_barang);
        try {
            $data2->update([
                'stok_barang' => $data2->stok_barang + $data->jumlah_barang_keluar
            ]);
            $data->delete();

            return $this->res(200, 'Berhasil', $data);
        } catch (\Illuminate\Database\QueryException $ex) {
            if($ex->getCode() === '23000') 
                return $this->errorFk();
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }
}