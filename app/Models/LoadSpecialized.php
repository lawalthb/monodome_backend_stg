<?php

namespace App\Models;

use App\Models\LoadType;
use Illuminate\Support\Str;
use App\Models\LocalGovernment;
use App\Traits\ComputeAddressTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadSpecialized extends Model
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function RLga()
    {
        return $this->belongsTo(LocalGovernment::class,'receiver_lga');
    }

    public function SLga()
    {
        return $this->belongsTo(LocalGovernment::class,'sender_lga');
    }


    public function RState(){
        return $this->belongsTo(State::class,'deliver_to_state');
    }

    public function DepCountry()
    {
        return $this->belongsTo(Country::class, "deliver_from_country");
    }

    public function DesCountry()
    {
        return $this->belongsTo(Country::class, "deliver_to_country");
    }

    public function SState(){
        return $this->belongsTo(State::class,'deliver_from_state');
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
        static::creating(function ($LoadSpecialized) {
            $LoadSpecialized->uuid = Str::uuid()->toString();
            $LoadSpecialized->user_id = auth()->id();
        });
    }
}
