<?php

namespace App\Models;

use App\Models\LoadType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadPackage extends Model
{
    use HasFactory;

    public $guarded = [];

        public function loadType()
        {
            return $this->belongsTo(LoadType::class);
        }

        public function loadDocuments()
        {
            return $this->morphMany(LoadDocument::class, 'loadable');
        }
}
