<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoadContainer extends Model
{
    use HasFactory;

    public function loadboard()
    {
        return $this->belongsTo(LoadBoard::class, 'loadboard_id');
    }
}
