<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycLimit extends Model
{
    use HasFactory;

    protected $table = 'kyc_limits';

    protected $fillable = [
        'kyc_level',
        'min_limit',
        'max_limit',
    ];
}
