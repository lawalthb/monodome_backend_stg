<?php

namespace App\Models;

use App\Models\Guarantor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;

    public $guarded = [];

    public function guarantors()
    {
        return $this->hasMany(Guarantor::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function country(){

        return $this->belongsTo(Country::class);
    }

    public function state(){

        return $this->belongsTo(State::class);
    }
}
