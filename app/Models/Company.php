<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    public $guarded = [];

    public function guarantors()
    {
        return $this->morphMany(Guarantor::class, 'loadable');
    }


    public function trucks(){

        return $this->hasOne(VehicleType::class,'id','truck_type');
    }

    public function SLga(){

        return $this->hasOne(LocalGovernment::class,'id','lga');
    }


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function country(){

        return $this->belongsTo(Country::class);
    }

    public function state(){

        return $this->belongsTo(State::class);
    }

    public function RLga()
    {
        return $this->belongsTo(LocalGovernment::class,'receiver_lga');
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
