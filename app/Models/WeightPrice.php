<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightPrice extends Model
{
    use HasFactory;

    protected $fillable = ['min_weight', 'max_weight', 'load_type_id', 'price'];

    public function loadType()
    {
        return $this->belongsTo(LoadType::class);
    }

}
