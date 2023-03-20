<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\User\UserController;
use App\Jobs\SendItemLine;

class SendLine implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $notification_id;

    public function __construct($notification_id)
    {
        $this->notification_id = $notification_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $userLine = NotificationController::listUser(UserController::CHANNEL_LINE);
        $data_notification = DB::table('notification')->where([
            'id'=>$this->notification_id
        ])->first();
        $mess = "{$data_notification->announce_title} - {$data_notification->announce_content}";
        foreach($userLine as $subUserLine) {
            SendItemLine::dispatch($mess,$subUserLine,$subUserLine);
        }
        
    }
}
