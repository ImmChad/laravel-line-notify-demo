<?php

namespace App\Console\Commands;

use App\Events\NewStoreRequestRegistrationEvent;
use App\Support\DripEmailer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SendNotificationWhenHavingNewStoreCommand extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $signature = 'notification:send-when-having-new-store';

    protected $description = 'Send to all girls the notification about the new established store every day at 18:00:00 ';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // TIM TAT CA STORE DANG KY TRONG VONG 24 GIO VUA ROI
        $stores = DB::table('store')->select('store_name', 'user_id')
            ->whereRaw('DATEDIFF(NOW(), created_at) <= 1')
            ->get();

        $returns = [];

        foreach ($stores as $store) {
            $returns[] = $store->store_name. "||".$store->user_id;
        }

        event(new NewStoreRequestRegistrationEvent($returns));
    }
}
