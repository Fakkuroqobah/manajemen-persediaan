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
        return $this->hasMany('App\Models\BarangKeluarDetail', 'id_barang_keluar', 'id_barang_keluar');
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