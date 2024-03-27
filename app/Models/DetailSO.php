<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSO extends Model
{
    use HasFactory;

    protected $fillable = [
       'so_id',
       'product_id',
       'kode_produk',
       'nama_produk',
       'qty',
       'keterangan',
       'so_price',
       'total_price',
       'kode_supplier',
       'kode_channel',
    ];

    public function produk()
    {

        return $this->belongsTo(Produk::class,'product_id');
    }

    public function salesorder()
    {

        return $this->belongsTo(SalesOrder::class, 'so_id');
    }
}
