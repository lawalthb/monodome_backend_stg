<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'expired',
        'status',
    ];


    public function users()
    {
        return $this->hasOne(User::class);
    }
}
