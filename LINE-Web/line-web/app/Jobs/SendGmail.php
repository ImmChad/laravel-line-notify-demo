<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use Mail;
use stdClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendGmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $textNotification ;
    public function __construct($textNotification)
    {
        $this->textNotification= $textNotification;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // $userLine = AdminController::listUser("connect to line");
        $userGmail = AdminController::listUser("connect to gmail");
        foreach($userGmail as $subUserGmail) {
            $textNotification = $this->textNotification;
            $email = $subUserGmail->email;
            
            Mail::send([],[], function ($message) use ($email, $textNotification) {
                $message->from(env('MAIL_FROM_ADDRESS'), 'Notification Web');
                $message->to($email);
                $message->subject("Notification");
                $message->html($textNotification);
            });
        }


    }
}
