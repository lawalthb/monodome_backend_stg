<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceSetting extends Model
{
    use HasFactory;


    public function loadType(){
        return $this->belongsTo(LoadType::class,'load_type_id');
    }
}
