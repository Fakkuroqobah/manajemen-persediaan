<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use DataTables;
use File;
use Str;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Barang::latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('gambar_barang', function($data) {
                    $src = $data->gambar_barang;
                    return '<img src="'. asset("storage/$src") .'" style="width: 120px">';
                })
                ->addColumn('aksi', function($data) {
                    return '<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="'. $data->id_barang .'" data-toggle="modal" data-target="#modal-edit" data-type="edit">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id_barang .'">Delete</a>';
                })
                ->rawColumns(['gambar_barang', 'aksi'])
                ->make(true);
        }

        return view('barang.barang');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|max:30',
            'jenis' => 'required|max:50',
            'stok' => 'required|max:30',
            'harga' => 'required',
        ]);

        $gambarPath = '';
        if($request->file('gambar') != null) {
            $gambar = $request->file('gambar');
            $gambarName = Str::random(8) . '.' . $gambar->clientExtension();

            $gambarPath = 'barang/' . $gambarName;
            $request->gambar->move(storage_path('app/public/barang'), $gambarName);
        }

        try {
            $data = Barang::create([
                'gambar_barang' => $gambarPath,
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
            'gambar' => 'nullable|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|max:30',
            'jenis' => 'required|max:50',
            'stok' => 'required|max:30',
            'harga' => 'required',
        ]);

        $data = Barang::findOrFail($id);
        $oldGambar = $data->gambar_barang;
        $gambarPath = $oldGambar;
        if($request->file('gambar') != null) {
            $gambar = $request->file('gambar');
            $gambarName = Str::random(8) . '.' . $gambar->clientExtension();

            $gambarPath = 'barang/' . $gambarName;
            $request->gambar->move(storage_path('app/public/barang'), $gambarName);

            File::delete('storage/' . $oldGambar);
        }

        try {
            $data->update([
                'gambar_barang' => $gambarPath,
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
        $old = $data->gambar_barang;
        try {
            $data->delete();
            File::delete('storage/' . $old);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Illuminate\Database\QueryException $ex) {
            if($ex->getCode() === '23000') 
                return $this->errorFk();
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }
}