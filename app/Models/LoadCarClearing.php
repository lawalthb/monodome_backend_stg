<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadCarClearing extends Model
{
    use HasFactory;
    public $guarded = [];

    public function loadboard()
    {
        return $this->belongsTo(LoadBoard::class, 'loadboard_id');
    }
}
