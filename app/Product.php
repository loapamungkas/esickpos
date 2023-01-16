<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Initialize
    protected $table = 'produk';
    protected $fillable = [
        'kode_barang', 'jenis_barang', 'nama_barang', 'stok', 'harga', 'keterangan',
    ];
}
