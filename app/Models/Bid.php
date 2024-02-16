<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    // protected $fillable = ['order_id', 'user_id','driver_id', 'amount','old_amount','order_no'];
    public $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(User::class,'driver_id');
        // return $this->belongsTo(Driver::class,'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
