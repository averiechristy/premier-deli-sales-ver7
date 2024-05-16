<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_channel',
        'nama_channel',
        'created_by',
        'updated_by',
    ];
}
