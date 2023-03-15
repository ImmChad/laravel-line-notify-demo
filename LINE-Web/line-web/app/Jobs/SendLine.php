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
    protected $param;

    public function __construct($param)
    {
        $this->param = $param;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $userLine = NotificationController::listUser(UserController::CHANNEL_LINE);
        // $userGmail = NotificationController::listUser("connect to gmail");
        foreach($userLine as $subUserLine) {
            $param =$this->param;
            SendItemLine::dispatch($param,$subUserLine,$subUserLine);
        }
        
    }
}
