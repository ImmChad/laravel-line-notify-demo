<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;

use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\User\UserController;
use App\Jobs\SendItemSMS;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $message;
    public function __construct($message)
    {
        $this->message =$message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->SMS_sendNotification($this->message);
    }
    function SMS_sendNotification($message)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $userSMS = NotificationController::listUser(UserController::CHANNEL_SMS);
        foreach($userSMS as $subUserSMS) {
            SendItemSMS::dispatch($client,$message,$subUserSMS);
        }
    }
}
