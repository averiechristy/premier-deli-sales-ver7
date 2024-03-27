<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_po',
        'po_date',
        'nama_user',
        'email',
        'user_id',
        'no_hp',
        'status_po',
        'created_by',
        'updated_by',
        'is_cancel',
        'kode_supplier',
        'kode_channel',
        'month',
    ];

    public function detailpurchase()
    {

        return $this->hasMany(DetailPO::class);
    }

    public function detailSoPo()
    {

        return $this->hasMany(DetailSoPo::class);
    }
}
