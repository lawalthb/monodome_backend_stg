<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriverManger extends Model
{
    use HasFactory;


    public $guarded = [];

    public function guarantors()
    {
        return $this->morphMany(Guarantor::class, 'loadable');
    }

    public function loadable()
    {
        return $this->morphTo('loadable');
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function country(){

        return $this->belongsTo(Country::class);
    }

    public function state(){

        return $this->belongsTo(LocalState::class);
    }

    public function local(){

        return $this->belongsTo(LocalGovernment::class,'lga');
    }


    public function user_created_by()
    {
        return $this->hasMany(User::class, 'user_created_by');
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
           // $model->user_id =  auth()->id();
        });
    }

}
