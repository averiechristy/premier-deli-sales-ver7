<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInvoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'product_id',
        'kode_produk',
        'nama_produk',
        'qty',
        'invoice_price'
     ];

     public function produk()
     {
 
         return $this->belongsTo(Produk::class,'product_id');
     }

     public function invoice()
     {
 
         return $this->belongsTo(Inovice::class);
     }
}
