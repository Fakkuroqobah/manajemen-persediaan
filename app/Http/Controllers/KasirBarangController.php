<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use DataTables;
use File;
use Str;

class KasirBarangController extends Controller
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
                ->rawColumns(['gambar_barang'])
                ->make(true);
        }

        return view('kasir_barang.kasir_barang');
    }
}