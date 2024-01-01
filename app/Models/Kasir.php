<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kasir extends Model
{
    protected $table = 'tb_kasir';
    protected $primaryKey = 'id_kasir';
    protected $guarded = ['id_kasir'];
    public $timestamps = true;
}