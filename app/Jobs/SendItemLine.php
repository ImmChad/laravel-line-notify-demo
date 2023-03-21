<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
class SendItemLine implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $param =null;
    protected $subUserLine = null;
    public function __construct( $param,$subUserLine)
    {
        $this->onQueue('item_line');
        $this->param = $param;
        $this->subUserLine = $subUserLine;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $param = $this->param;
        $subUserLine = $this->subUserLine;
        $httpClient = new CurlHTTPClient(env('LINE_BOT_CHANNEL_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_BOT_CHANNEL_SECRET')]);
        $message = new TextMessageBuilder($param);
        $bot->pushMessage($subUserLine->address, $message); 
    }
}
