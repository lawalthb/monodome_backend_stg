<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarStatePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'state_id',
        'price',
    ];
}
