<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use DataTables;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Barang::latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($data) {
                    return '<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="'. $data->id_barang .'" data-toggle="modal" data-target="#modal-edit" data-type="edit">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id_barang .'">Delete</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('barang.barang');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:30',
            'jenis' => 'required|max:50',
            'stok' => 'required|max:30',
            'harga' => 'required',
        ]);

        try {
            $data = Barang::create([
                'nama_barang' => $request->nama,
                'jenis_barang' => $request->jenis,
                'stok_barang' => $request->stok,
                'harga_barang' => $request->harga
            ]);

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = Barang::findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nama' => 'required|max:30',
            'jenis' => 'required|max:50',
            'stok' => 'required|max:30',
            'harga' => 'required',
        ]);

        $data = Barang::findOrFail($id);
        try {
            $data->update([
                'nama_barang' => $request->nama,
                'jenis_barang' => $request->jenis,
                'stok_barang' => $request->stok,
                'harga_barang' => $request->harga
            ]);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Barang::findOrFail($id);
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