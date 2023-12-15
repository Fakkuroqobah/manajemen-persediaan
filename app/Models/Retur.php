<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    protected $table = 'tb_barang_retur';
    protected $primaryKey = 'id_barang_retur';
    protected $guarded = ['id_barang_retur'];
    public $timestamps = true;

    public function penjualan()
    {
        return $this->belongsTo('App\Models\BarangKeluar', 'id_barang_keluar', 'id_barang_keluar');
    }
}