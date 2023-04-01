<?php

namespace App\Jobs;


use App\Handler\NotificationHandler;
use App\Repository\NotificationRepository;
use App\Services\NotificationService;
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
    protected $notification_id;

    /**
     * @param $notification_id
     */
    public function __construct($notification_id)
    {
        $this->notification_id = $notification_id;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data_notification = DB::table('notification')->where([
            'id'=>$this->notification_id
        ])
        ->where('deleted_at','=',null)
        ->first();

        if(isset($data_notification))
        {
            $notificationRepository = new NotificationRepository();
            $dataNotificationDraft = $notificationRepository->getNotificationDraftWithID($data_notification->notification_draft_id);
            $userLine = [];
            if($dataNotificationDraft->notification_for == "user")
            {
                $userLine = $notificationRepository->getSeekerHasLineWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id,$dataNotificationDraft->created_at);
            }
            else if ($dataNotificationDraft->notification_for == "store")
            {
                $userLine = $notificationRepository->getStoreHasLineWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id,$dataNotificationDraft->created_at);
            }
            $notificationService = new NotificationService($notificationRepository);

            foreach($userLine as $subUserLine) {
                $content = "";
                if($dataNotificationDraft->notification_for == "user")
                {
                    $content = $notificationService->loadParamNotificationUser($data_notification->announce_content,$subUserLine->id);
                }
            else if ($dataNotificationDraft->notification_for == "store")
                {
                    $content = $notificationService->loadParamNotificationStore($data_notification->announce_content,$subUserLine->id) ;
                }

                $mess = "{$data_notification->announce_title} - {$content}";
                SendItemLine::dispatch($mess,$subUserLine->lineId);
            }

            DB::table('notification')->where([
                'id'=>$this->notification_id
            ])
            ->where('deleted_at','=',null)
            ->update(['is_sent'=>1]);
        }
    }
}
