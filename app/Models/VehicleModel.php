<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleModel extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];


    public function make()
    {
        return $this->belongsTo(VehicleMake::class, 'vehicle_make_id');
    }

    // public function type()
    // {
    //     return $this->belongsTo(VehicleType::class);
    // }

    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new vehicle model when creating it
        static::creating(function ($vehicleModel) {
            $vehicleModel->uuid = Str::uuid()->toString();
        });
    }

}
