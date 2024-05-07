<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_customer',
        'kategori',
        'sumber',
        'nama_pic',
        'jabatan_pic',
        'no_hp',
        'email',
        'produk_sebelumnya',
        'lokasi',
        'kategori_id',
        'sumber_id'
    ];

    public function rfo()
    {

        return $this->hasMany(RFO::class);
    }

    public function quote()
    {

        return $this->hasMany(Quotation::class);
    }

    public function salesorder()
    {

        return $this->hasMany(SalesOrder::class);
    }

    public function invoice()
    {

        return $this->hasMany(Inovice::class);
    }

    public function deliveryorder()
    {

        return $this->hasMany(DeliveryOrder::class);
    }

    public function kategori()
    {

        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function sumber()
    {

        return $this->belongsTo(Sumber::class, 'sumber_id');
    }
}
