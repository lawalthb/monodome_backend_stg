<?php

namespace App\Models;

use App\Models\User;
use App\Models\State;
use App\Models\Country;
use App\Models\Guarantor;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;

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

    public function loadDocuments()
    {
        return $this->morphMany(LoadDocument::class, 'loadable');
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function RLga()
    {
        return $this->belongsTo(LocalGovernment::class,'lga');
    }

    public function country(){

        return $this->belongsTo(Country::class);
    }

    public function vehicleType(){

        return $this->belongsTo(VehicleType::class,'vehicle_type_id');
    }

    public function state(){

        return $this->belongsTo(State::class);
    }

    public function order(){

        return $this->hasMany(Order::class);
    }

    public function acceptedOrders()
{
    return $this->hasMany(Order::class, 'order_no');
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
