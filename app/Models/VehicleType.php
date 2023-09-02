<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleType extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new vehicle type when creating it
        static::creating(function ($vehicleType) {
            $vehicleType->uuid = Str::uuid()->toString();
        });
    }

    public function vehicleMakes()
    {
        return $this->hasMany(VehicleMake::class, 'vehicle_type_id');
    }

}
