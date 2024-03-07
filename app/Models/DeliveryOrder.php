<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;
    protected $fillable = [
       'invoice_id',
       'do_date',
       'cust_id',
    ];

    public function customer()
    {

        return $this->belongsTo(Customer::class);
    }

    public function detaildo()
    {

        return $this->hasMany(DetailDO::class);
    }
}
