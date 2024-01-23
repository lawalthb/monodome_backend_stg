<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistancePrice extends Model
{
    use HasFactory;
    protected $fillable = ['min_km', 'max_km', 'load_type_id', 'price'];

    public function loadType()
    {
        return $this->belongsTo(LoadType::class);
    }
}
