<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'tb_barang_keluar';
    protected $primaryKey = 'id_barang_keluar';
    protected $guarded = ['id_barang_keluar'];
    public $timestamps = true;

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'id_barang', 'id_barang');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'id_customer', 'id_customer');
    }
}