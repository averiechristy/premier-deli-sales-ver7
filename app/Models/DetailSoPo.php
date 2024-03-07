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
