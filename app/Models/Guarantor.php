<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantor extends Model
{
    use HasFactory;

    public $guarded = [];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function shippingCompany()
    {
        return $this->belongsTo(ShippingCompany::class);
    }

    public function state(){

        return $this->belongsTo(LocalState::class);
    }

    public function local(){

        return $this->belongsTo(LocalGovernment::class,'lga');
    }

    public function loadable()
    {
        return $this->morphTo('loadable');
    }
}
