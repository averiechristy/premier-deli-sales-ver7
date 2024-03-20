<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_quote',
        'nama_penerima',
        'nama_customer',
        'alamat',
        'email',
        'no_hp',
        'nama_pic',
        'quote_date',
        'valid_date',
        'cust_id',
        'shipping_date',
        'payment_date',
        'status_quote',
        'is_persen',
        'discount',
        'ppn'
    ];

    public function customer()
    {

        return $this->belongsTo(Customer::class, 'cust_id');
    }

    public function detailquote()
    {

        return $this->hasMany(DetailQuotation::class);
    }
}
