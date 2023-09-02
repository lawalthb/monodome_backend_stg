<?php

namespace App\Models;

use App\Models\LoadType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadCarClearing extends Model
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

protected static function boot()
{
    parent::boot();

    // Generate a UUID for the new vehicle model when creating it
    static::creating(function ($LoadCarClearing) {
        $LoadCarClearing->uuid = Str::uuid()->toString();
    });
}
}
