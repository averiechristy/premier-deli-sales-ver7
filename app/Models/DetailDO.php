<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailDO extends Model
{
    use HasFactory;
    protected $fillable = [
        'do_id',
        'product_id',
        'kode_produk',
        'nama_produk',
        'qty',
     ];

     public function produk()
     {
 
         return $this->belongsTo(Produk::class);
     }

     public function deliveryorder()
    {

        return $this->belongsTo(DeliveryOrder::class);
    }
}
