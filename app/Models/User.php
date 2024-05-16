<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'username',
        'role_id',
        'email',
        'password',
        'created_by',
        'no_hp',
        'updated_by',
        'report_to',
    ];
    public function rfo()
    {

        return $this->hasMany(RFO::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


  

    public function Role()
    {

        return $this->belongsTo(UserRole::class, 'role_id');
    }
    public function isSuperAdmin()
    {
        $jenis_role = $this->Role->jenis_role;
        return strtoupper($jenis_role) === 'SUPER ADMIN';
    }

    public function isAdminInvoice()
    {
        $jenis_role = $this->Role->jenis_role;
        return strtoupper($jenis_role) === 'ADMIN INVOICE';
    }

    public function isAdminProduk()
    {
        $jenis_role = $this->Role->jenis_role;
        return strtoupper($jenis_role) === 'ADMIN PRODUK';
    }

    public function isLeader()
    {
        $jenis_role = $this->Role->jenis_role;
        return strtoupper($jenis_role) === 'LEADER';
    }

    public function isSales()
    {
        $jenis_role = $this->Role->jenis_role;
        return strtoupper($jenis_role) === 'SALES';
    }

    public function isManager()
    {
        $jenis_role = $this->Role->jenis_role;
        return strtoupper($jenis_role) === 'MANAGER';
    }
}
