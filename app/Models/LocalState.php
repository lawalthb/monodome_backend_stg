<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalState extends Model
{
    use HasFactory;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function lga()
    {
        return $this->hasMany(LocalGovernment::class, 'state_id');
    }

    public function commissions()
    {
        return $this->hasMany(AgentCommission::class, 'state_id');
    }
}
