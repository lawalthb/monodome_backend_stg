<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    public $guarded = [];


   // Define relationship with User model
   public function users()
   {
       return $this->hasMany(User::class);
   }
}
