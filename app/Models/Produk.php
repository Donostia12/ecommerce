<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = "produk";
    protected $fillable = [
        'name',
        'stock',
        'desc',
        'harga',
        'image',
        'status',
    ];
}
