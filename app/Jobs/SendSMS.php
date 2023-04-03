<?php

namespace App\Jobs;

use App\Handler\NotificationHandler;
use App\Repository\NotificationDraftRepository;
use App\Repository\NotificationRepository;
use App\Services\NotificationService;
use App\Services\NotificationUserService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

use Twilio\Rest\Client;

use App\Http\Controllers\User\UserController;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $notificationId;

    public function __construct(
        int                                $notificationId,
        public NotificationRepository      $notificationRepository,
        public NotificationDraftRepository $notificationDraftRepository,
        public NotificationService         $notificationService,
        public NotificationUserService     $notificationUserService
    )
    {
        $this->notificationId = $notificationId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->SMS_sendNotification();
    }

    function SMS_sendNotification()
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $client = new Client($account_sid, $auth_token);

        $data_notification = DB::table('notification')->where([
            'id' => $this->notificationId
        ])
            ->where('deleted_at', '=', null)
            ->first();

        if (isset($data_notification)) {
            $dataNotificationDraft = $this->notificationDraftRepository->getNotificationDraftWithID($data_notification->notification_draft_id);
            $userSMS = [];

            if ($dataNotificationDraft->notification_for == "user") {
                $userSMS = $this->notificationUserService->getSeekerOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id, $dataNotificationDraft->created_at);
            } else if ($dataNotificationDraft->notification_for == "store") {
                $userSMS = $this->notificationUserService->getStoreOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id, $dataNotificationDraft->created_at);
            }


            foreach ($userSMS as $subUserSMS) {

                $title = "";
                $content = "";

                if ($dataNotificationDraft->notification_for == "user") {
                    $title = $this->notificationService->loadParamNotificationSeeker($data_notification->announce_title, $subUserSMS->id);
                    $content = $this->notificationService->loadParamNotificationSeeker($data_notification->announce_content, $subUserSMS->id);
                } else if ($dataNotificationDraft->notification_for == "store") {
                    $content = $this->notificationService->loadParamNotificationStore($data_notification->announce_content, $subUserSMS->id);
                    $title = $this->notificationService->loadParamNotificationStore($data_notification->announce_title, $subUserSMS->id);
                }


                $mess = "{$title} \r\n {$content}";
                SendItemSMS::dispatch($client, $mess, $subUserSMS->phoneNumberDecrypted);
            }

            DB::table('notification')->where([
                'id' => $this->notificationId
            ])
                ->where('deleted_at', '=', null)
                ->update(['is_sent' => 1]);
        }

    }
}
