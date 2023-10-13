<?php

namespace App\Models;

use App\Models\LoadPackage;
use Illuminate\Support\Str;
use App\Models\LoadContainer;
use App\Models\LoadCarClearing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadType extends Model
{
    use HasFactory;

    public $guarded = [];

    // Define the polymorphic relationship
    public function loadable()
    {
        return $this->morphTo();
    }


    public function loadboards()
    {
        return $this->hasMany(LoadBoard::class, 'load_type_id');
    }


    public function loadPackages()
    {
        return $this->hasMany(LoadPackage::class);
    }

    public function loadContainers()
    {
        return $this->hasMany(LoadContainer::class, 'load_type_id', 'id');
    }

    public function loadCarClearings()
    {
        return $this->hasMany(LoadCarClearing::class, 'load_type_id', 'id');
    }

    public function loadBulks()
    {
        return $this->hasMany(LoadBulk::class, 'load_type_id', 'id');
    }


    public function specificType()
    {
        // Define a relationship to the specific type (Package, Bulk, or Container)
        switch ($this->id) {
            case 1:
                return $this->hasOne(LoadPackage::class);
            case 2:
                return $this->hasOne(LoadBulk::class);
            case 3:
                return $this->hasOne(LoadCarClearing::class);
            case 4:
                return $this->hasOne(LoadContainer::class);
            case 5:
                return $this->hasOne(LoadSpecialized::class);
            default:
                return null;
        }
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
