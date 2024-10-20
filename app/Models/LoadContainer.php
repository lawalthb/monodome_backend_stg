<?php

namespace App\Models;

use App\Models\LoadType;
use Illuminate\Support\Str;
use App\Traits\ComputeAddressTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadContainer extends Model
{
    use HasFactory, ComputeAddressTrait;

    protected $casts = [ ];

    public $guarded = [];

    public function loadType()
    {
        return $this->belongsTo(LoadType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function containerCarrier(){

        return $this->hasOne(ContainerCarrier::class,'id');
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'loadable');
    }

    public function RLga()
        {
            return $this->belongsTo(LocalGovernment::class,'receiver_lga');
        }

        public function SLga()
        {
            return $this->belongsTo(LocalGovernment::class,'sender_lga');
        }

        public function DepCountry()
    {
        return $this->belongsTo(Country::class, "departure_country");
    }

    public function DFromCity()
    {
        return  $this->belongsTo(State::class, 'deliver_from_city');
    }

    public function DToCity()
    {
        return  $this->belongsTo(State::class, 'deliver_to_city');
    }

    public function DesCountry()
    {
        return $this->belongsTo(Country::class, "destination_country");
    }

        public function RState(){
            return $this->belongsTo(State::class,'receiver_state');
        }

        public function SState(){
            return $this->belongsTo(State::class,'sender_state');
        }
    public function loadBoard()
    {
        return $this->morphOne(LoadBoard::class, 'loadable');
    }

    public function isLoadTypeLoadable()
    {
        return $this->loadBoard !== null;
    }

    public function loadDocuments()
{
    return $this->morphMany(LoadDocument::class, 'loadable');
}

protected static function boot()
{
    parent::boot();

    // Generate a UUID for the new vehicle model when creating it
    static::creating(function ($LoadContainer) {
        $LoadContainer->uuid = Str::uuid()->toString();
        $LoadContainer->user_id = auth()->id();
    });
}

}
