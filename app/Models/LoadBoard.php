<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadBoard extends Model
{
    use HasFactory;

    public function loadType()
    {
        return $this->belongsTo(LoadType::class, 'load_type_id');
    }

    // Define relationships with specific load types
    public function specialized()
    {
        return $this->hasOne(LoadSpecialized::class, 'loadboard_id');
    }

    public function carClearing()
    {
        return $this->hasOne(LoadCarClearing::class, 'loadboard_id');
    }

    public function container()
    {
        return $this->hasOne(LoadContainer::class, 'loadboard_id');
    }

    public function package()
    {
        return $this->hasOne(LoadPackage::class, 'load_board_id');
    }
}
