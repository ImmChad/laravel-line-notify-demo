<?php

namespace App\Listeners;

use App\Jobs\SendMail;
use App\Jobs\SendLine;
use App\Jobs\SendSMS;

use App\Events\NewNotificationFromAdminEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
class TriggerForNewNotificationFromAdminListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {


    }

    /**
     * Handle the event.
     */
    public function handle(NewNotificationFromAdminEvent $event): void
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        date_default_timezone_get();
        $data_notification = DB::table('notification')->where([
            'id'=>$event->notification_id
        ])->first();
            if(isset($data_notification))
            {
                SendLine::dispatch($event->notification_id)->delay(Carbon::parse($data_notification->scheduled_at));
                SendMail::dispatch($event->notification_id)->delay(Carbon::parse($data_notification->scheduled_at));
                SendSMS::dispatch($event->notification_id)->delay(Carbon::parse($data_notification->scheduled_at)); 
            }
            else
            {

            }

    }
}
