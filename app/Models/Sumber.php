<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'sumber',
        'created_by',
        'updated_by',
      ];

      public function customer()
      {
  
          return $this->hasMany(Customer::class);
      }
}
