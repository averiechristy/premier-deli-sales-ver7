<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul_catatan',
        'isi_catatan',
        'created_by',
        'updated_by',
    ];
}
