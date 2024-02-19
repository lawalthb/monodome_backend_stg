<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarCountryPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'price',
        'status',
    ];
}
