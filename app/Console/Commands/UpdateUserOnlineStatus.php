<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserOnlineStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-online-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user online status based on last_online timestamp';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Define the time limit
        $timeLimit = now()->subMinutes(10);

        // Find users with `last_online` older than 10 minutes and update `isOnline` to false
        $updatedCount = User::where('last_online', '<', $timeLimit)
            ->update(['isOnline' => false]);

        // Output result
       // $this->info("Updated {$updatedCount} users' online status to false.");

        return 0;
    }
}
