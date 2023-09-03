<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    public $guarded = [];


    // protected $fillable = [
    //     'name',
    //     'agent_id',
    //     'address',
    //     'country_id',
    //     'state_id',
    //     'status',
    // ];

    public function agent()
{
    return $this->belongsTo(Agent::class);
}

public function country()
{
    return $this->belongsTo(Country::class);
}


public function state()
{
    return $this->belongsTo(State::class);
}


}
