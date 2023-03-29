<?php

namespace App\Jobs;


use App\Handler\NotificationHandler;
use App\Repository\NotificationRepository;
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
        $notificationRepository = new NotificationRepository();
        $handler = new NotificationHandler($notificationRepository);
        $userLine = $handler->listUser(UserController::CHANNEL_LINE);

//        $userLine = NotificationHandler::listUser(UserController::CHANNEL_LINE);

        $data_notification = DB::table('notification')->where([
            'id'=>$this->notification_id
        ])
        ->where('deleted_at','=',null)
        ->first();

        if(isset($data_notification))
        {
            $mess = "{$data_notification->announce_title} - {$data_notification->announce_content}";
            foreach($userLine as $subUserLine) {
                SendItemLine::dispatch($mess,$subUserLine);
            }

            $data_notification = DB::table('notification')->where([
                'id'=>$this->notification_id
            ])
            ->where('deleted_at','=',null)
            ->update(['is_sent'=>1]);
        }
    }
}
