<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadBulk extends Model
{
    use HasFactory;

    public $guarded = [];
    public function loadType()
    {
        return $this->belongsTo(LoadType::class);
    }

    public function loadBoard()
    {
        return $this->morphOne(LoadBoard::class, 'loadable');
    }

    public function loadDocuments()
    {
        return $this->morphMany(LoadDocument::class, 'loadable');
    }

    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new vehicle model when creating it
        static::creating(function ($LoadBulk) {
            $LoadBulk->uuid = Str::uuid()->toString();
        });
    }
}
