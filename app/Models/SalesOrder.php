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
    ];

    public function customer()
    {

        return $this->belongsTo(Customer::class);
    }

    public function detailso()
    {

        return $this->hasMany(DetailSO::class);
    }
    public function detailSoPo()
    {

        return $this->hasMany(DetailSoPo::class);
    }
}
