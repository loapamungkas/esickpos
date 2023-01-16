<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // Initialize
    protected $table = 'transaksi';
    protected $fillable = [
        'kode_transaksi', 'id_barang', 'jumlah', 'total_barang', 'subtotal', 'diskon', 'total', 'bayar', 'kembali', 'id_kasir', 'kasir',
    ];
}
