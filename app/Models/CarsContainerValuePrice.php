<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarsContainerValuePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'min', 'max', 'price', 'status'
    ];
}
