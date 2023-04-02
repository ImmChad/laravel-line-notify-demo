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
use App\Http\Controllers\User\UserController;

class SendLine implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected int $notificationId;

    /**
     * @param int $notificationId
     */
    public function __construct(
        int $notificationId,
        private NotificationRepository $notificationRepository,
        private NotificationDraftRepository $notificationDraftRepository,
        private NotificationUserService $notificationUserService
    )
    {
        $this->notificationId = $notificationId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data_notification = DB::table('notification')->where([
            'id' => $this->notificationId
        ])
            ->where('deleted_at', '=', null)
            ->first();

        if (isset($data_notification)) {
            $notificationRepository = new NotificationRepository();
            $dataNotificationDraft = $this->notificationDraftRepository->getNotificationDraftWithID($data_notification->notification_draft_id);
            $userLine = [];

            if ($dataNotificationDraft->notification_for == "user") {
                $userLine = $this->notificationUserService->getSeekerHasLineWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id, $dataNotificationDraft->created_at);
            } else if ($dataNotificationDraft->notification_for == "store") {
                $userLine = $this->notificationUserService->getStoreHasLineWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id, $dataNotificationDraft->created_at);
            }

            $notificationService = new NotificationService($notificationRepository);

            foreach ($userLine as $subUserLine) {
                $title = "";
                $content = "";

                if ($dataNotificationDraft->notification_for == "user") {
                    $title = $notificationService->loadParamNotificationUser($data_notification->announce_title, $subUserLine->id);
                    $content = $notificationService->loadParamNotificationUser($data_notification->announce_content, $subUserLine->id);
                } else if ($dataNotificationDraft->notification_for == "store") {
                    $title = $notificationService->loadParamNotificationStore($data_notification->announce_title, $subUserLine->id);
                    $content = $notificationService->loadParamNotificationStore($data_notification->announce_content, $subUserLine->id);
                }

                $mess = "{$title} \r\n \r\n {$content}";
                SendItemLine::dispatch($mess, $subUserLine->lineId);
            }

            DB::table('notification')->where([
                'id' => $this->notificationId
            ])
                ->where('deleted_at', '=', null)
                ->update(['is_sent' => 1]);
        }
    }
}
