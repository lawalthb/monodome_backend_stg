<?php

namespace App\Models;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Define relationships if any, for example:
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

}
