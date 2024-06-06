<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inovice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_no',
        'so_id',
        'quote_id',
        'no_so',
        'no_quote',
        'cust_id',
        'invoice_date',
        'created_by',
        'updated_by',
        'status_invoice',
        'is_closing',
        'biaya_pengiriman',
    ];

    public function customer()
    {

        return $this->belongsTo(Customer::class, 'cust_id');
    }
    public function so()
    {

        return $this->belongsTo(SalesOrder::class, 'so_id');
    }

    public function detailinvoice()
    {

        return $this->hasMany(Inovice::class);
    }
}
