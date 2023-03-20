<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\User\UserController;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mail;
use stdClass;

use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\SendItemMail;
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
        
        $userGmail = NotificationController::listUser(UserController::CHANNEL_EMAIL);
            // for($i=1;$i<=100;$i++)
            // {
        $data_notification = DB::table('notification')->where([
            'id'=>$this->notification_id
        ])->first();
        // $mess = "{$data_notification->announce_title} - {$data_notification->announce_content}";
                foreach($userGmail as $subUserGmail) {
                    $textNotification = $data_notification->announce_content;
                    $email = $subUserGmail->email;
                    $titleSubject =$data_notification->announce_title;
                    SendItemMail::dispatch($email,$textNotification,$titleSubject);
                }
            // }
    }
}
