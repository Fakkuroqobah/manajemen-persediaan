<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluarDetail extends Model
{
    protected $table = 'tb_penjualan_detail';
    protected $primaryKey = 'id_penjualan_detail';
    protected $guarded = ['id_penjualan_detail'];
    public $timestamps = true;

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'id_barang', 'id_barang');
    }

    public function barangKeluar()
    {
        return $this->belongsTo('App\Models\BarangKeluar', 'id_penjualan', 'id_penjualan');
    }
}