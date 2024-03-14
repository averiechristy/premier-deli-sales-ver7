<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RFO extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_penerima',
        'cust_id',
        'alamat',
        'nama_customer',
        'shipping_date',
        'payment_date',
        'updated_by',
        'created_by',
        'status',
        'status_rfo',
        'no_rfo',
    ];

    public function customer()
    {

        return $this->belongsTo(Customer::class);
    }

    public function salesorder()
    {

        return $this->hasMany(SalesOrder::class);
    }

    public function detailrfo()
    {

        return $this->hasMany(DetailRFO::class);
    }
}
