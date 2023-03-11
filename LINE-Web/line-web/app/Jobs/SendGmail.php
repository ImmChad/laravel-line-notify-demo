<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\AdminController;
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
use App\Jobs\SendItemGmail;
class SendGmail implements ShouldQueue
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
        
        $userGmail = AdminController::listUser("connect to gmail");
            foreach($userGmail as $subUserGmail) {
                $textNotification = $this->textNotification;
                $email = $subUserGmail->email;
                $titleSubject = $this->titleSubject;
                SendItemGmail::dispatch($email,$textNotification,$titleSubject);
            }
    }
}
