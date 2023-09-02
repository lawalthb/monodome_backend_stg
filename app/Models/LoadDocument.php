<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadDocument extends Model
{
    use HasFactory;
    public $guarded = [];

    public function loadable()
    {
        return $this->morphTo('loadable');
    }
}
