<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CancelApprovalSA extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_id',
        'invoice_id',
        'role_id',
        'alasan',
        'report_to',
        'status_cancel',
      ];
}
