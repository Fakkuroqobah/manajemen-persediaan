<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kasir;
use DataTables;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Kasir::latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($data) {
                    return '<a href="#" class="btn btn-sm mr-2 btn-warning edit" data-id="'. $data->id_kasir .'" data-toggle="modal" data-target="#modal-edit" data-type="edit">Edit</a>' .
                        '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id_kasir .'">Delete</a>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('kasir.kasir');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:30',
            'alamat' => 'required|max:30',
            'telepon' => 'required|max:13'
        ]);

        try {
            $data = Kasir::create([
                'nama_kasir' => $request->nama,
                'alamat_kasir' => $request->alamat,
                'telepon_kasir' => $request->telepon
            ]);

            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function show($id)
    {
        $data = Kasir::findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'nama' => 'required|max:30',
            'alamat' => 'required|max:30',
            'telepon' => 'required|max:13'
        ]);

        $data = Kasir::findOrFail($id);
        try {
            $data->update([
                'nama_kasir' => $request->nama,
                'alamat_kasir' => $request->alamat,
                'telepon_kasir' => $request->telepon
            ]);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = Kasir::findOrFail($id);
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