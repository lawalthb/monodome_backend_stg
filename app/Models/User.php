<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Wallet;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions,SoftDeletes, \OwenIt\Auditing\Auditable;


    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $guarded = [];


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
        'location' => 'array',
    ];

    public function loadBulk(){

        return $this->hasMany(LoadBulk::class);
    }

    public function loadPackage(){

        return $this->hasMany(LoadPackage::class);
    }

    public function loadCarClearing(){

        return $this->hasMany(LoadCarClearing::class);
    }

    public function loadContainer(){

        return $this->hasMany(LoadContainer::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function walletHistories()
    {
        return $this->hasMany(WalletHistory::class);
    }


    public function driver()
{
    return $this->hasOne(Driver::class);
}

    public function getImagePathAttribute()
    {
        if ($this->imageUrl)
        {
            return $this->imageUrl;
        } else {
            return 'uploads/default/user.png';
        }
    }
}
