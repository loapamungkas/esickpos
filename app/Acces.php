<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acces extends Model
{
    protected $table = 'akses';
    // Initialize
    protected $fillable = [
        'user', 'kelola_akun', 'kelola_barang', 'transaksi', 'kelola_laporan',
    ];
}
