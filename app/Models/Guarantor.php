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

    public function loadable()
    {
        return $this->morphTo('loadable');
    }
}