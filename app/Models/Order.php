<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public $guarded = [];

    public function loadable()
    {
    return $this->morphTo('loadable');
    }

    public function user(){

        return $this->belongsTo(User::class);
    }


    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new vehicle model when creating it
        static::creating(function ($Order) {
            $Order->uuid = Str::uuid()->toString();
        });
    }

}
