<?php

namespace App\Models;

use App\Models\LoadType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadPackage extends Model
{
    use HasFactory;

    public $guarded = [];

        public function loadType()
        {
            return $this->belongsTo(LoadType::class);
        }

        public function officeTo()
        {
            return $this->belongsTo(Agent::class,'to_office_id');
        }

        public function officeFrom()
        {
            return $this->belongsTo(Agent::class,'from_office_id');
        }


        public function loadBoard()
    {
        return $this->morphOne(LoadBoard::class, 'loadable');
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'loadable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function loadDocuments()
        {
            return $this->morphMany(LoadDocument::class, 'loadable');
        }

        public function RLga()
        {
            return $this->belongsTo(LocalGovernment::class,'receiver_lga');
        }

        public function SLga()
        {
            return $this->belongsTo(LocalGovernment::class,'sender_lga');
        }


        public function RState(){
            return $this->belongsTo(LocalState::class,'receiver_state');
        }

        public function SState(){
            return $this->belongsTo(LocalState::class,'sender_state');
        }

        protected static function boot()
        {
            parent::boot();

            // Generate a UUID for the new vehicle model when creating it
            static::creating(function ($LoadPackage) {
                $LoadPackage->uuid = Str::uuid()->toString();
                $LoadPackage->user_id = auth()->id();
            });
        }
}
