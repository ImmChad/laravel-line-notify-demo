<?php

namespace App\Jobs;

use App\Handler\NotificationHandler;
use App\Http\Controllers\User\UserController;

use App\Repository\NotificationRepository;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;
use Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $notification_id;

    public function __construct($notification_id)
    {
        $this->notification_id = $notification_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notificationRepository = new NotificationRepository();


        $notificationData = DB::table('notification')->where([
            'id' => $this->notification_id
        ])
            ->where('deleted_at', '=', null)
            ->first();

        if (isset($notificationData)) {
            $notificationRepository = new NotificationRepository();
            $dataNotificationDraft = $notificationRepository->getNotificationDraftWithID($notificationData->notification_draft_id);
            $userGmail = [];
            if($dataNotificationDraft->notification_for == "user")
            {
                $userGmail = $notificationRepository->getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id,$dataNotificationDraft->created_at);
            }
            else if ($dataNotificationDraft->notification_for == "store")
            {
                $userGmail = $notificationRepository->getStoreNotLineHasMailWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id,$dataNotificationDraft->created_at);
            }
            $notificationService = new NotificationService($notificationRepository);
            foreach ($userGmail as $subUserGmail) {
                $content = "";
                if($dataNotificationDraft->notification_for == "user")
                {
                    $content = $notificationService->loadParamNotificationUser($notificationData->announce_content,$subUserGmail->id);
                }
                else if ($dataNotificationDraft->notification_for == "store")
                {
                    $content = $notificationService->loadParamNotificationStore($notificationData->announce_content,$subUserGmail->id) ;
                }
                $email = $subUserGmail->emailDecrypted;
                $titleSubject = $notificationData->announce_title;
                SendItemMail::dispatch($email, $content, $titleSubject);

            }
            DB::table('notification')->where([
                'id' => $this->notification_id
            ])
                ->where('deleted_at', '=', null)
                ->update(['is_sent' => 1]);
        }

    }
}
