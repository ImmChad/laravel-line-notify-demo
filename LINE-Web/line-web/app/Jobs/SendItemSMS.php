<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendItemSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $message;
    protected $client;
    protected $subUserSMS;


    public function __construct($client,$message,$subUserSMS)
    {
        $this->onQueue('item_sms');
        $this->message = $message;
        $this->client = $client;
        $this->subUserSMS = $subUserSMS;


    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $message = $this->message;
        $client = $this->client;
        $subUserSMS = $this->subUserSMS;


        $res = $client->messages
        ->create($subUserSMS->user_id, // to
                 [
                     "body" => $message,
                     "messagingServiceSid" => $twilio_number = getenv("TWILIO_SMS_SERVICE_ID")
                 ]
        );
    }
}
