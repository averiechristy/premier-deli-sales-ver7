<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRFO extends Model
{
    use HasFactory;
    protected $fillable = [
        'rfo_id',
        'product_id',
        'kode_produk',
        'nama_produk',
        'qty',
    ];

    public function produk()
    {

        return $this->belongsTo(Produk::class);
    }

    public function rfo()
    {

        return $this->belongsTo(RFO::class);
    }
}
