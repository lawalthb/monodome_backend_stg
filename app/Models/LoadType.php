<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
