<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailQuotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'product_id',
        'kode_produk',
        'nama_produk',
        'qty',
        'quote_price',
        'total_price',
        'kode_supplier',
        'kode_channel',
        'kode_supplier'
    ];

    public function produk()
    {

        return $this->belongsTo(Produk::class,'product_id');
    }

    public function quotation()
    {

        return $this->belongsTo(Quotation::class, 'quote_id');
    }
}
