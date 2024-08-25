<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public $guarded = [];

    public function loadable()
    {
    return $this->morphTo('loadable');
    }

    public function acceptable()
    {
        return $this->morphTo();
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function truck(){

        return $this->belongsTo(User::class,'truck_by_id','id');
    }

    public function driver(){

        return $this->belongsTo(User::class,'driver_id','id');
    }

    public function qr(){

        return $this->hasMany(QrCode::class,'order_no');
    }

    public function insured(){

        return $this->hasMany(insurance::class,'order_no');
    }


    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new vehicle model when creating it
        static::creating(function ($Order) {
            $Order->uuid = Str::uuid()->toString();
        });
    }

}
