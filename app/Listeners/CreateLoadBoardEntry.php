<?php

namespace App\Listeners;

use App\Models\LoadBoard;
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

         $loadTypeId = $event->loadType->id;
         $userId = Auth::user()->id; // Adjust this according to your LoadType model

         $load_board = new LoadBoard();
         $load_board->user_id = $userId;
         $load_board->loadable()->associate($event->loadType);
         $load_board->load_type_id = $loadTypeId;
         $load_board->loadtype_name = $event->loadType->load_type_name; // You may need to define this method
         $load_board->order_no = getNumber();
         $load_board->status = 'Pending'; // Set the initial status
         $load_board->save();
    }
}
