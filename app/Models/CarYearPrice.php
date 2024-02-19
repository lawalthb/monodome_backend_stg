<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarYearPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'price',
        'status',
    ];
}
