<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSoPo extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_id',
        'so_id',
        'rfo_id',
        'quote_id',
        'no_po',
        'no_so',
        'no_rfo',
        'no_quote',
        'kode_supplier',
    ];
    public function salesorder()
    {

        return $this->belongsTo(SalesOrder::class);
    }

    public function purchaseorder()
    {

        return $this->belongsTo(PurchaseOrder::class);
    }
}
