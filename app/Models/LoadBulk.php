<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadBulk extends Model
{
    use HasFactory;

    public $guarded = [];
    public function loadType()
    {
        return $this->belongsTo(LoadType::class, 'load_type_id', 'load_type_id')
            ->where('load_type_type', 'load_car_clearing');
    }

    public function loadDocuments()
{
    return $this->morphMany(LoadDocument::class, 'loadable');
}
}
