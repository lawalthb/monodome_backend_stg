<?php

namespace App\Models;

use App\Models\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AgentCommission extends Model
{
    use HasFactory;

    protected $fillable = ['state_id', 'percentage'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
