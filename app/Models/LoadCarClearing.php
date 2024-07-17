<?php

namespace App\Models;

use App\Models\LoadType;
use Illuminate\Support\Str;
use App\Traits\ComputeAddressTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadCarClearing extends Model
{
    use HasFactory, ComputeAddressTrait;
    public $guarded = [];

    public function loadType()
    {
        return $this->belongsTo(LoadType::class);
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'loadable');
    }

    public function loadBoard()
    {
        return $this->morphOne(LoadBoard::class, 'loadable');
    }

    public function loadDocuments()
    {
        return $this->morphMany(LoadDocument::class, 'loadable');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function DepCountry()
    {
        return $this->belongsTo(Country::class, "departure_country");
    }

    public function DesCountry()
    {
        return $this->belongsTo(Country::class, "destination_country");
    }

    public function carType()
    {
        return $this->belongsTo(VehicleType::class, "car_type");
    }

    public function carModel()
    {
        return $this->belongsTo(VehicleModel::class, "car_model");
    }

    public function carMake()
    {
        return $this->belongsTo(VehicleMake::class, "car_make");
    }

    public function DFromCity()
    {
        return  $this->belongsTo(State::class, 'deliver_from_city');
    }

    public function DToCity()
    {
        return  $this->belongsTo(State::class, 'deliver_to_city');
    }

    public function isLoadTypeLoadable()
    {
        return $this->loadBoard !== null;
    }


    //local state
    public function LState()
    {
        return  $this->belongsTo(LocalState::class, 'receiver_state');
    }


    public function LFState()
    {
        return  $this->belongsTo(LocalState::class, 'receiver_final_dt_state');
    }


    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new vehicle model when creating it
        static::creating(function ($LoadCarClearing) {
            $LoadCarClearing->uuid = Str::uuid()->toString();
            $LoadCarClearing->user_id = auth()->id();
        });
    }
}
