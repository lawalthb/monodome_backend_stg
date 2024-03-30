<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestPayment extends Model
{
    use HasFactory;
    public $guarded = [];

    public function sender()
    {
        return $this->belongsTo(User::class,'request_sender');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'request_receiver');
    }

    // public function currency()
    // {
    //     return $this->belongsTo(Currency::class);
    // }


    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
