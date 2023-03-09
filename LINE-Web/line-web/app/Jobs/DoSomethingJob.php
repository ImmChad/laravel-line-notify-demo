<?php

namespace App\Jobs;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class DoSomethingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $param;
    protected $userId;

    public function __construct($param, $userId)
    {
        $this->param = $param;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $param = $this->param;
        $userId = $this->userId;

        $httpClient = new CurlHTTPClient(env('LINE_BOT_CHANNEL_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_BOT_CHANNEL_SECRET')]);
        
        $message = new TextMessageBuilder($param);
        $bot->pushMessage($userId, $message); 
        
    }
}
