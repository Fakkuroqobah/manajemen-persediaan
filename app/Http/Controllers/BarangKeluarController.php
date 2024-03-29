<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\BarangKeluarDetail;
use App\Models\Customer;
use App\Models\Barang;
use App\Models\Kasir;
use Barryvdh\DomPDF\Facade\Pdf;
use DataTables;
use DB;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::all();
        $customer = Customer::all();
        $kasir = Kasir::all();

        if($request->ajax()) {
            $data = BarangKeluar::with(['barang.barang', 'customer', 'kasir'])->latest();
            
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

                    foreach ($data->barang as $item) {
                        $total += $item->jumlah_barang_keluar * $item->barang->harga_barang;
                        $view .= '<tr>
                            <td>'. $item->barang->nama_barang .'</td>
                            <td>'. $item->jumlah_barang_keluar .'</td>
                            <td>Rp.'. $item->barang->harga_barang .'</td>
                            <td>Rp.'. $item->jumlah_barang_keluar * $item->barang->harga_barang .'</td>
                        </tr>';
                    }

                    $view .= '<tr>
                        <td colspan="3">Toal harga</td>
                        <td class="total_harga">Rp.'. $total .'</td>
                    </tr>';

                    if($data->nota == 1) {
                        $view .= '<tr class="bg-success text-white">
                            <td colspan="4" class="text-center">LUNAS</td>
                        </tr>';
                    }

                    $view .= '</table>';
                    return $view;
                })
                ->addColumn('tanggal_penjualan', function($data) {
                    return date('d-m-Y H:i', strtotime($data->tanggal_penjualan));
                })
                ->addColumn('aksi', function($data) {
                    $nota = '';
                    if($data->nota == 0) {
                        $nota .= '<span class="mx-1"></span>
                            <a href="#" class="btn btn-sm btn-success mt-2 mt-lg-0 mb-2 mb-lg-0 nota" data-toggle="modal" data-target="#modal-nota" data-total="0" data-id="'. $data->id_penjualan .'">Nota</a>';
                    }else{
                        $nota .= '<span class="mx-1"></span>
                            <a href="'. route('nota', $data->id_penjualan) .'" class="btn btn-sm btn-success mt-2 mt-lg-0 mb-2 mb-lg-0">Nota</a>';
                    }

                    return '<a href="#" class="btn btn-sm btn-primary edit" data-toggle="modal" data-target="#modal-edit" data-id="'. $data->id_penjualan .'">Tambah</a>
                        '. $nota .'    
                        <span class="mx-1"></span>
                        <a href="#" class="btn btn-sm btn-danger mt-2 mt-lg-0 mb-2 mb-lg-0 delete" data-id="'. $data->id_penjualan .'">Delete</a>';
                })
                ->rawColumns(['aksi', 'barang'])
                ->make(true);
        }

        return view('barang_keluar.barang_keluar', compact('barang', 'customer', 'kasir'));
    }

    public function find($id)
    {
        $data = BarangKeluarDetail::with(['barang'])->where('id_penjualan', $id)->get();
        return $this->res(200, 'Berhasil', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required',
            'id_barang' => 'required',
            'id_customer' => 'required',
            'id_kasir' => 'required',
        ]);

        $check = Barang::findOrFail($request->id_barang);
        if($check->stok_barang < $request->jumlah) {
            return $this->res(422, 'Gagal', 'Jumlah yang diminta tidak memenuhi stok saat ini');
        }

        DB::beginTransaction();
        try {
            $data = BarangKeluar::create([
                'tanggal_penjualan' => now(),
                'id_customer' => $request->id_customer,
                'id_kasir' => $request->id_kasir
            ]);

            BarangKeluarDetail::create([
                'jumlah_barang_keluar' => $request->jumlah,
                'id_barang' => $request->id_barang,
                'id_penjualan' => $data->id_penjualan
            ]);

            $data = Barang::findOrFail($request->id_barang);
            $data->update([
                'stok_barang' => $data->stok_barang - $request->jumlah
            ]);

            DB::commit();
            return $this->res(201, 'Berhasil', $data);
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }
    
    public function nota($id, $jumlah = null, $uang = null)
    {
        $data = BarangKeluar::with(['barang.barang', 'customer'])->findOrFail($id);
        
        if($data->nota == 0) {
            if($uang > $jumlah) {
                return redirect()->back()->with('danger', 'Uang pembayaran masih kurang');
            }
    
            $data->update([
                'jumlah_bayar' => $jumlah,
                'nota' => 1,
            ]);
        }else{
            $jumlah = $data->jumlah_bayar;
        }

        $pdf = Pdf::loadView('nota', compact('data', 'jumlah'));
        return $pdf->download('nota.pdf');
    }

    public function show($id)
    {
        $data = BarangKeluar::with(['barang', 'customer'])->findOrFail($id);

        return $this->res(200, 'Berhasil', $data);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'jumlah' => 'required',
            'id_barang' => 'required',
        ]);

        $check = Barang::findOrFail($request->id_barang);
        if($check->stok_barang < $request->jumlah) {
            return $this->res(422, 'Gagal', 'Jumlah yang diminta tidak memenuhi stok saat ini');
        }

        try {
            BarangKeluarDetail::create([
                'jumlah_barang_keluar' => $request->jumlah,
                'id_barang' => $request->id_barang,
                'id_penjualan' => $id
            ]);

            $data = Barang::findOrFail($request->id_barang);
            $data->update([
                'stok_barang' => $data->stok_barang - $request->jumlah
            ]);

            return $this->res(200, 'Berhasil', $data);
        } catch (\Throwable $e) {
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $data = BarangKeluar::with(['barang'])->findOrFail($id);
        
        DB::beginTransaction();
        try {
            foreach ($data->barang as $item) {
                $data2 = Barang::findOrFail($item->id_barang);
                $data2->update([
                    'stok_barang' => $data2->stok_barang + $item->jumlah_barang_keluar
                ]);
            }
            $data->delete();

            DB::commit();
            return $this->res(200, 'Berhasil', $data);
        } catch (\Illuminate\Database\QueryException $ex) {
            DB::rollback();
            if($ex->getCode() === '23000') 
                return $this->errorFk();
        } catch (\Throwable $e) {
            DB::rollback();
            return $this->res(500, 'Gagal', $e->getMessage());
        }
    }
}