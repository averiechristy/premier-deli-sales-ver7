<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_so',
        'cust_id',
        'so_date',
        'created_by',
        'updated_by',
        'so_price',
        'is_persen',
        'discount',
        'ppn',
        'pembayaran',
        'rfo_id',
        'status_so',
        'is_cetak',
        'is_download',
    ];

    public function customer()
    {

        return $this->belongsTo(Customer::class, 'cust_id');
    }

    public function rfo()
    {

        return $this->belongsTo(RFO::class, 'rfo_id');
    }



    public function detailso()
    {

        return $this->hasMany(DetailSO::class);
    }
    public function detailSoPo()
    {

        return $this->hasMany(DetailSoPo::class);
    }

    public function invoice()
    {

        return $this->hasMany(Inovice::class);
    }
}
