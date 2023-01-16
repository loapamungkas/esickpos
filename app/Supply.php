<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    // Initialize
    protected $table = 'pasok';
    protected $fillable = [
        'id_barang', 'jumlah', 'id_user'
    ];
}
