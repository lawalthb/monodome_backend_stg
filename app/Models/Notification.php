<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    public $guarded = [];

    public function user(){

        return $this->belongsTo(User::class);
    }


    public function notifiable()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->id =  Str::uuid()->toString();
           // $model->user_id =  auth()->id();
        });
    }
}
