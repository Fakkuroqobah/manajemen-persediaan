<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'tb_supplier';
    protected $primaryKey = 'id_supplier';
    protected $guarded = ['id_supplier'];
    public $timestamps = true;
}