<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleMake extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded = [];

    public function models()
    {
        return $this->hasMany(VehicleModel::class);
    }



    public function getLogoPathAttribute()
    {
        if ($this->logo)
        {
            return $this->logo;
        } else {
            return 'uploads/default/no-image-found.png';
        }
    }



    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new vehicle model when creating it
        static::creating(function ($vehicleMake) {
            $vehicleMake->uuid = Str::uuid()->toString();
        });
    }
}
