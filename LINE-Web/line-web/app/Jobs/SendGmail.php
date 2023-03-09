<?php

namespace App\Jobs;
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
    protected $emailTo ;
    protected $textNotification ;
    public function __construct($emailTo,$textNotification)
    {
        $this->emailTo= $emailTo;
        $this->textNotification= $textNotification;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $emailTo = $this->emailTo;
        $textNotification = $this->textNotification;
        
        Mail::send([],[], function ($message) use ($emailTo,$textNotification) {
            $message->from(env('MAIL_FROM_ADDRESS'), 'Notification Web');
            $message->to($emailTo);
            $message->subject("Notification");
            $message->html($textNotification);
        });


    }
}
