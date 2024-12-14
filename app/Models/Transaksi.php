<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = "transaksi";
    protected $fillable = [
        'id_produk',
        'id_user',
        'amount',
        'status',
        'penerima',
        'alamat',
        'telp',
        'total'
    ];
}
