<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRoutePlan extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];

}
