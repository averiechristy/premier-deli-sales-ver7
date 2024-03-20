<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelApproval extends Model
{
    use HasFactory;
    protected $fillable = [
       'rfo_id',
       'role_id',
       'alasan',
       'status_cancel',
       'id_report',
       'report_role',
     ];
}
