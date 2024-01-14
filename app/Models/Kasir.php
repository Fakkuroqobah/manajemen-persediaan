<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Kasir extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tb_kasir';
    protected $primaryKey = 'id_kasir';
    protected $guarded = ['id_kasir'];
    public $timestamps = true;

    protected $hidden = [
        'password'
    ];
}