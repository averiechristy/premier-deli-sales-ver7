<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [

        'kode_supplier',
        'nama_supplier',
        'alamat_supplier',
        'created_by',
        'updated_by',
        

    ];

    public function produk()
    {

        return $this->hasMany(Produk::class);
    }
}
