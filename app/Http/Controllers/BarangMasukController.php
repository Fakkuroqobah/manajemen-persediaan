<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use App\Models\Barang;
use DataTables;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::all();
        $supplier = Supplier::all();

        if($request->ajax()) {
            $data = BarangMasuk::with(['barang', 'supplier'])->latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($data) {
                    return '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id_barang_masuk .'">Delete</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('barang_masuk.barang_masuk', compact('barang', 'supplier'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'jumlah' => 'required',
            'id_barang' => 'required',
            'id_supplier' => 'required',
        ]);

        try {
            $data = BarangMasuk::create([
                'tanggal_barang_masuk' => $request->tanggal,
                'jumlah_barang_masuk' => $request->jumlah,
                'id_barang' => $request->id_barang,
                'id_supplier' => $request->id_supplier
            ]);

            $data = Barang::findOrFail($request->id_barang);
            $data->update([
                'stok_barang' => $data->stok_barang + $request->jumlah
            ]);

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = BarangMasuk::with(['barang', 'supplier'])->findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'jumlah' => 'required',
            'id_barang' => 'required',
            'id_supplier' => 'required',
        ]);

        $data = BarangMasuk::findOrFail($id);
        try {
            $data->update([
                'tanggal_barang_masuk' => $request->tanggal,
                'jumlah_barang_masuk' => $request->jumlah,
                'id_barang' => $request->id_barang,
                'id_supplier' => $request->id_supplier
            ]);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = BarangMasuk::findOrFail($id);
        $data2 = Barang::findOrFail($data->id_barang);
        try {
            $data2->update([
                'stok_barang' => $data2->stok_barang - $data->jumlah_barang_masuk
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