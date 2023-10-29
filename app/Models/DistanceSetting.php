<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DistanceSetting extends Model
{
    use HasFactory;

    public $guarded = [];

   /**
     * Get the owning loadable model.
     */
    public function loadable(): MorphTo
    {
        return $this->morphTo();
    }
}
