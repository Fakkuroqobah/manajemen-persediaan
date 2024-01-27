<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetail;
use App\Models\Retur;
use DataTables;

class ReturController extends Controller
{
    public function index(Request $request)
    {
        $barang = BarangKeluar::with(['customer', 'barang'])->get();

        if($request->ajax()) {
            $data = Retur::with(['penjualan.barangKeluar.customer', 'penjualan.barang'])->latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($data) {
                    return '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id_barang_retur .'">Delete</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('retur.retur', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'id_penjualan_detail' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required',
        ]);

        $check = BarangKeluarDetail::findOrFail($request->id_penjualan_detail);
        if($check->jumlah_barang_keluar < $request->jumlah) {
            return $this->res(422, 'Gagal', 'Jumlah yang diminta melebihi barang yang dibeli');
        }

        try {
            $data = Retur::create([
                'tanggal_barang_retur' => $request->tanggal,
                'id_penjualan_detail' => $request->id_penjualan_detail,
                'deskripsi' => $request->deskripsi,
                'jumlah' => $request->jumlah,
            ]);

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = Retur::with(['penjualan'])->findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'id_penjualan' => 'required'
        ]);

        $data = Retur::findOrFail($id);
        try {
            $data->update([
                'tanggal_barang_retur' => $request->tanggal,
                'id_penjualan' => $request->id_penjualan
            ]);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Retur::findOrFail($id);
        try {
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