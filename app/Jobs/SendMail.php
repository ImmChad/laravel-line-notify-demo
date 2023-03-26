<?php

namespace App\Jobs;

use App\Handler\NotificationHandler;
use App\Http\Controllers\User\UserController;

use App\Repository\NotificationRepository;
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

    protected $notification_id ;

    public function __construct($notification_id)
    {
        $this->notification_id= $notification_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notificationRepository = new NotificationRepository();
        $handler = new NotificationHandler($notificationRepository);
        $userGmail = $handler->listUser(UserController::CHANNEL_EMAIL);

//        $userGmail = NotificationHandler::listUser(UserController::CHANNEL_EMAIL);

        $data_notification = DB::table('notification')->where([
            'id'=>$this->notification_id
        ])
        ->where('deleted_at','=',null)
        ->first();

        if(isset($data_notification))
        {
            foreach($userGmail as $subUserGmail) {
                $textNotification = $data_notification->announce_content;
                $email = $subUserGmail->address;
                $titleSubject =$data_notification->announce_title;
                SendItemMail::dispatch($email,$textNotification,$titleSubject);
            }
            $data_notification = DB::table('notification')->where([
                'id'=>$this->notification_id
            ])
            ->where('deleted_at','=',null)
            ->update(['is_sent'=>1]);
        }

    }
}
