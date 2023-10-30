<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Truck extends Model
{
    use HasFactory;

    public $guarded = [];

    public function loadable()
    {
        return $this->morphTo('loadable');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function loadDocuments()
    {
        return $this->morphMany(LoadDocument::class, 'loadable');
    }


    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
           // $model->uuid =  getOTPNumber(6);
           // $model->user_id =  auth()->id();
        });
    }

}
