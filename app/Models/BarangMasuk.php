<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = 'tb_barang_masuk';
    protected $primaryKey = 'id_barang_masuk';
    protected $guarded = ['id_barang_masuk'];
    public $timestamps = true;

    public function barang()
    {
        return $this->belongsTo('App\Models\Barang', 'id_barang', 'id_barang');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'id_supplier', 'id_supplier');
    }
}