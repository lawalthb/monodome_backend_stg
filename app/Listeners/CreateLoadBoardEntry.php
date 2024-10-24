<?php

namespace App\Listeners;

use App\Models\Tracking;
use App\Models\LoadBoard;
use App\Models\OrderRoutePlan;
use App\Events\LoadTypeCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateLoadBoardEntry
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LoadTypeCreated $event)
    {
         $loadTypeId = $event->loadType->load_type_id;
         $userId = Auth::user()->id;

        $existingLoadBoard = LoadBoard::where('loadable_id', $event->loadType->id)
        ->where('loadable_type', get_class($event->loadType))
        ->first();

        if ($existingLoadBoard) {
            return;
        }

         $load_board = new LoadBoard();
         $load_board->user_id = $userId;
         $load_board->loadable()->associate($event->loadType);
         $load_board->load_type_id = $loadTypeId;
         $load_board->load_type_name = $event->loadType->loadType->slug;
         $load_board->order_no = $event->loadType->order->order_no;
         $load_board->status = 'pending';
         $load_board->save();


         $data = [
            'order_no' => $event->loadType->order->order_no,
            'comment' => "Payment success and Packaging load",
            'time' => now(),
            'longitude' => null,
            'latitude' => null,
            'location' => null,
            'driver_id' => null,
            'status' => 'pending',
        ];

        $tracking = Tracking::create($data);

    }
}
