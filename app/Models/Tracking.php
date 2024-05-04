<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tracking extends Model
{
    use HasFactory;

    public $guarded = [];


    public function order(){

        return $this->belongsTo(Order::class,'order_no','order_no');
    }


    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->tracking_id =  Str::uuid()->toString();
           // $model->user_id =  auth()->id();
        });
    }
}
