<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriceSetting extends Model
{
    use HasFactory;

    public $guarded = [];

    public function loadType(){
        return $this->belongsTo(LoadType::class,'load_type_id');
    }

    public function distancePrice(){
        return $this->hasMany(DistanceSetting::class);
    }

    /**
     * Get all of the owning models that own the price settings.
     */
    public function distanceSettings(): MorphMany
    {
        return $this->morphMany(DistanceSetting::class, 'loadable');
    }
}
