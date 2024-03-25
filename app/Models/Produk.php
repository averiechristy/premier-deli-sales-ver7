<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'harga_jual',
        'harga_beli',
        'kode_supplier',
        'nama_supplier',
    ];


    public function detailrfo()
    {

        return $this->hasMany(DetailRFO::class);
    }

    public function detailso()
    {

        return $this->hasMany(DetailSO::class);
    }
    public function detailpo()
    {

        return $this->hasMany(DetailPO::class);
    }

    public function detailinvoice()
    {

        return $this->hasMany(DetailInvoice::class);
    }
    public function detaildo()
    {

        return $this->hasMany(DetailDO::class);
    }
}
