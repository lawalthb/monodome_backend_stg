<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadBulk extends Model
{
    use HasFactory;

    public $guarded = [];
    public function loadType()
    {
        return $this->belongsTo(LoadType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $this->belongsTo(State::class,'receiver_state');
    }

    public function SState(){
        return $this->belongsTo(State::class,'sender_state');
    }


    public function loadBoard()
    {
        return $this->morphOne(LoadBoard::class, 'loadable');
    }

    public function loadDocuments()
    {
        return $this->morphMany(LoadDocument::class, 'loadable');
    }

    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new vehicle model when creating it
        static::creating(function ($LoadBulk) {
            $LoadBulk->uuid = Str::uuid()->toString();
            $LoadBulk->user_id = auth()->id();
        });
    }
}
