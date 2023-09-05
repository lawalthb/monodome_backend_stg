<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalGovernment extends Model
{
    use HasFactory;

    public $guarded = [];


    public function state()
    {
        return $this->belongsTo(State::class);
    }

}
