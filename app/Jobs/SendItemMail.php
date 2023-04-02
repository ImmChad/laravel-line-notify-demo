<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;
use stdClass;

class SendItemMail implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $textNotification;
    protected $titleSubject;
    protected $email;

    public function __construct($email, $textNotification, $titleSubject)
    {
        $this->onQueue('item_email');
        $this->email = $email;
        $this->textNotification = $textNotification;
        $this->titleSubject = $titleSubject;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $textNotification = $this->textNotification;
        $titleSubject = $this->titleSubject;
        $email = $this->email;
        if(isset($email))
        {
            Mail::send([], [], function ($message) use ($email, $titleSubject, $textNotification) {
                $message->from(env('MAIL_FROM_ADDRESS'), 'Notification Web');
                $message->to($email);
                $message->subject($titleSubject);
                $message->html($textNotification);
            });
        }
    }

    public function failed(Throwable $exception): void
    {
        // echo 'fail :(';
        // Artisan::call('queue:retry --queue=item_email');
    }
    // public function retryUntil()
    // {
    //     return now()->addSeconds(5);
    // }

}
