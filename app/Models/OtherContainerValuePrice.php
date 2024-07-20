<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherContainerValuePrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'min', 'max', 'price', 'status'
    ];
}
