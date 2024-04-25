<?php

namespace App\Models;

use App\Http\Resources\DriverResource;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public $guarded = [];

    public function loadable()
    {
    return $this->morphTo('loadable');
    }

    public function acceptable()
    {
        return $this->morphTo();
    }

    public function user(){

        return $this->belongsTo(User::class);
    }


    public function driver()
    {
      //  dd($this->truck_by_id);
        //return $this->truck_by_id;
        $truck = Truck::where("user_id",$this->truck_by_id)->first();

        return new DriverResource(Driver::where("user_id",$truck->driver_user_id)->first());
    }


    public function truck(){

        return $this->belongsTo(User::class,'truck_by_id','id');
    }

    public function qr(){

        return $this->hasMany(QrCode::class,'order_no');
    }

    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new vehicle model when creating it
        static::creating(function ($Order) {
            $Order->uuid = Str::uuid()->toString();
        });
    }

}
