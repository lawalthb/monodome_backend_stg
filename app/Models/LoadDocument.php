<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadDocument extends Model
{
    use HasFactory;
    public $guarded = [];

    public function loadable()
    {
    return $this->morphTo('loadable');
    }

    public function getFilePathAttribute()
    {
        if ($this->path) {
            return $this->path;
        } else {
            return 'uploads/default/no-image-found.png';
        }
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'loadable');
    }

    public function isLoadTypeLoadable()
    {
        return $this->loadBoard !== null;
    }

    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new vehicle model when creating it
        static::creating(function ($LoadDocument) {
            $LoadDocument->uuid = Str::uuid()->toString();
        });
    }
}
