<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function walletHistories()
    {
        return $this->hasMany(WalletHistory::class);
    }


    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){

            $randomPart1 = rand(1000, 9999); // Generates a random 4-digit number
            $randomPart2 = rand(1000, 9999); // Generates another random 4-digit number
            $randomPart3 = rand(100, 999);   // Generates a random 3-digit number
            $randomPart4 = rand(1000, 9999); // Generates another random 4-digit number
            $uniqueID = "$randomPart1 $randomPart2 $randomPart3 $randomPart4";

            $model->uuid =  $uniqueID ;//Str::uuid()->toString();
           // $model->user_id =  auth()->id();
        });
    }



}
