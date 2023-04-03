<?php

namespace App\Jobs;

use App\Handler\NotificationHandler;
use App\Http\Controllers\User\UserController;

use App\Repository\NotificationDraftRepository;
use App\Repository\NotificationRepository;
use App\Services\NotificationService;
use App\Services\NotificationUserService;
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

    protected $notificatioId;

    public function __construct(
        int                                $notificationId,
        public NotificationRepository      $notificationRepository,
        public NotificationDraftRepository $notificationDraftRepository,
        public NotificationService         $notificationService,
        public NotificationUserService     $notificationUserService
    )
    {
        $this->notificatioId = $notificationId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notificationData = DB::table('notification')->where([
            'id' => $this->notificatioId
        ])
            ->where('deleted_at', '=', null)
            ->first();

        if (isset($notificationData)) {
            $dataNotificationDraft = $this->notificationDraftRepository->getNotificationDraftWithID($notificationData->notification_draft_id);
            $userGmail = [];

            if ($dataNotificationDraft->notification_for == "user") {
                $userGmail = $this->notificationUserService->getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id, $dataNotificationDraft->created_at);
            } else if ($dataNotificationDraft->notification_for == "store") {
                $userGmail = $this->notificationUserService->getStoreNotLineHasMailWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id, $dataNotificationDraft->created_at);
            }


            foreach ($userGmail as $subUserGmail) {
                $title = "";
                $content = "";

                if ($dataNotificationDraft->notification_for == "user") {
                    $title = $this->notificationService->loadParamNotificationSeeker($notificationData->announce_title, $subUserGmail->id, "mail");
                    $content = $this->notificationService->loadParamNotificationSeeker($notificationData->announce_content, $subUserGmail->id, "mail");
                } else if ($dataNotificationDraft->notification_for == "store") {
                    $title = $this->notificationService->loadParamNotificationStore($notificationData->announce_title, $subUserGmail->id, "mail");
                    $content = $this->notificationService->loadParamNotificationStore($notificationData->announce_content, $subUserGmail->id, "mail");
                }

                $email = $subUserGmail->emailDecrypted;
                SendItemMail::dispatch($email, $content, $title);

            }

            DB::table('notification')->where([
                'id' => $this->notificatioId
            ])
                ->where('deleted_at', '=', null)
                ->update(['is_sent' => 1]);
        }

    }
}
