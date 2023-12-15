<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'tb_customer';
    protected $primaryKey = 'id_customer';
    protected $guarded = ['id_customer'];
    public $timestamps = true;
}