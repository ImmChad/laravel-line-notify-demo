<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

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
    protected $notification_id;
    public function __construct($notification_id)
    {
        $this->notification_id =$notification_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->SMS_sendNotification();
    }
    function SMS_sendNotification()
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $userSMS = NotificationController::listUser(UserController::CHANNEL_SMS);
        $data_notification = DB::table('notification')->where([
            'id'=>$this->notification_id
        ])->first();
        $mess = "{$data_notification->announce_title} - {$data_notification->announce_content}";
        foreach($userSMS as $subUserSMS) {
            SendItemSMS::dispatch($client,$mess,$subUserSMS);
        }
    }
}
