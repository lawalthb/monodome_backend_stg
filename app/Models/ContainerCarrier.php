<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerCarrier extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function shipments()
{
    return $this->hasOne(LoadContainer::class);
}
}