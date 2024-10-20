<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Traits\ComputeAddressTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoadBulk extends Model
{
    use HasFactory, ComputeAddressTrait;

    public $guarded = [];
    public function loadType()
    {
        return $this->belongsTo(LoadType::class);
    }

    public function officeTo()
    {
        return $this->belongsTo(Agent::class, 'to_office_id');
    }

    public function officeFrom()
    {
        return $this->belongsTo(Agent::class, 'from_office_id');
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'loadable');
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
        return $this->belongsTo(LocalState::class,'receiver_state');
    }

    public function SState(){
        return $this->belongsTo(LocalState::class,'sender_state');
    }

    public function loadBoard()
    {
        return $this->morphOne(LoadBoard::class, 'loadable');
    }

    public function loadDocuments()
    {
        return $this->morphMany(LoadDocument::class, 'loadable');
    }

    public function office(){
        return $this->belongsTo(Agent::class,'to_office_id');
    }

    public function isLoadTypeLoadable()
    {
        return $this->loadBoard !== null;
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
