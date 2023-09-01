<?php

namespace App\Models;

use App\Models\LoadPackage;
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
}
