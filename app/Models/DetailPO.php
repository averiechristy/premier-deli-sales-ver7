<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPO extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_id',
        'product_id',
        'kode_produk',
        'nama_produk',
        'qty',
        'po_price',
        'total_price',
        'kode_supplier',
        'discount',
        'amount',
        'total_price_after_discount',
    ];

    public function produk()
    {

        return $this->belongsTo(Produk::class);
    }

    public function purchaseorder()
    {

        return $this->belongsTo(PurchaseOrder::class);
    }
}
