<?php

namespace App\Listeners;

use App\Jobs\SendMail;
use App\Jobs\SendLine;
use App\Jobs\SendSMS;

use App\Events\NewNotificationFromAdminEvent;
use App\Repository\NotificationDraftRepository;
use App\Repository\NotificationRepository;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

/**
 *
 */
class TriggerForNewNotificationFromAdminListener implements ShouldQueue
{

    /**
     *
     */
    public function __construct()
    {
    }

    /**
     * @param NewNotificationFromAdminEvent $event
     *
     * @return void
     */
    public function handle(NewNotificationFromAdminEvent $event): void
    {
        $data_notification = DB::table('notification')->where([
            'id' => $event->notificationId
        ])->first();

        if (isset($data_notification)) {
            SendLine::dispatch(
                $event->notificationId,
                $event->notificationRepository,
                $event->notificationDraftRepository,
                $event->notificationService,
                $event->notificationUserService
            )->delay(Carbon::parse($data_notification->scheduled_at));

            SendMail::dispatch(
                $event->notificationId,
                $event->notificationRepository,
                $event->notificationDraftRepository,
                $event->notificationService,
                $event->notificationUserService
            )->delay(Carbon::parse($data_notification->scheduled_at));

            SendSMS::dispatch(
                $event->notificationId,
                $event->notificationRepository,
                $event->notificationDraftRepository,
                $event->notificationService,
                $event->notificationUserService
            )->delay(Carbon::parse($data_notification->scheduled_at));
        }
    }
}
