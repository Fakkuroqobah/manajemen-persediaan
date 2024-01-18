<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $table = 'tb_penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $guarded = ['id_penjualan'];
    public $timestamps = true;

    public function barang()
    {
        return $this->hasMany('App\Models\BarangKeluarDetail', 'id_penjualan', 'id_penjualan');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'id_customer', 'id_customer');
    }

    public function kasir()
    {
        return $this->belongsTo('App\Models\Kasir', 'id_kasir', 'id_kasir');
    }
}