<?php

namespace App\Models;

use App\Models\LoadType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadSpecialized extends Model
{
    use HasFactory;

    public function loadType()
    {
        return $this->belongsTo(LoadType::class, 'load_type_id', 'load_type_id')
            ->where('load_type_type', 'load_bulk');
    }


    public function loadDocuments()
{
    return $this->morphMany(LoadDocument::class, 'loadable');
}
}
