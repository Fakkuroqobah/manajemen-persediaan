<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Retur;
use DataTables;

class KasirReturController extends Controller
{
    public function index(Request $request)
    {
        $barang = BarangKeluar::with(['customer', 'barang'])->get();

        if($request->ajax()) {
            $data = Retur::with(['penjualan.customer', 'penjualan.barang'])->latest();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('barang', function($data) {
                    $view = '<table class="table table-bordered">';
                    $total = 0;

                    $view .= '<tr>
                        <th>Nama barang</th>
                        <th>Jumlah</th>
                        <th>Harga satuan</th>
                        <th>Total</th>
                    </tr>';

                    foreach ($data->penjualan->barang as $item) {
                        $total += $item->jumlah_barang_keluar * $item->barang->harga_barang;
                        $view .= '<tr>
                            <td>'. $item->barang->nama_barang .'</td>
                            <td>'. $item->jumlah_barang_keluar .'</td>
                            <td>'. $item->barang->harga_barang .'</td>
                            <td>'. $item->jumlah_barang_keluar * $item->barang->harga_barang .'</td>
                        </tr>';
                    }

                    $view .= '<tr>
                        <td colspan="3">Toal harga</td>
                        <td>'. $total .'</td>
                    </tr>';

                    $view .= '</table>';
                    return $view;
                })
                ->addColumn('aksi', function($data) {
                    return '<a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id_barang_retur .'">Delete</a>';
                })
                ->rawColumns(['barang', 'aksi'])
                ->make(true);
        }

        return view('kasir_retur.kasir_retur', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required',
            'id_barang_keluar' => 'required'
        ]);

        try {
            $data = Retur::create([
                'tanggal_barang_retur' => $request->tanggal,
                'id_barang_keluar' => $request->id_barang_keluar
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
            'id_barang_keluar' => 'required'
        ]);

        $data = Retur::findOrFail($id);
        try {
            $data->update([
                'tanggal_barang_retur' => $request->tanggal,
                'id_barang_keluar' => $request->id_barang_keluar
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