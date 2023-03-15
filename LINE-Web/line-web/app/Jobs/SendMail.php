<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\User\UserController;

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

    protected $textNotification ;
    protected $titleSubject ;
    public function __construct($textNotification,$titleSubject)
    {
        $this->textNotification= $textNotification;
        $this->titleSubject= $titleSubject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        
        $userGmail = NotificationController::listUser(UserController::CHANNEL_EMAIL);
            // for($i=1;$i<=100;$i++)
            // {
                foreach($userGmail as $subUserGmail) {
                    $textNotification = $this->textNotification;
                    $email = $subUserGmail->email;
                    $titleSubject = $this->titleSubject;
                    SendItemMail::dispatch($email,$textNotification,$titleSubject);
                }
            // }
    }
}
