<?php

namespace App\Listeners;

use App\Events\NewEmailMagazineEvent;
use App\Jobs\SendMail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class TriggerForNewEmailMagazineListener implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewEmailMagazineEvent $event): void
    {
        $data_notification = DB::table('notification')->where([
            'id'=>$event->notificationId
        ])->first();
            if(isset($data_notification))
            {
                SendMail::dispatch($event->notificationId)->delay(Carbon::parse($data_notification->scheduled_at));
            }
            else
            {

            }
    }
}
