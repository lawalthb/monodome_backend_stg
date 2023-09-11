<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;

    public $guarded = [];

    public function guarantors()
    {
        return $this->morphMany(Guarantor::class, 'loadable');
    }
}
