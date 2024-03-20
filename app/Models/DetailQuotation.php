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
    ];

    public function quotation()
    {

        return $this->belongsTo(Quotation::class);
    }
}
