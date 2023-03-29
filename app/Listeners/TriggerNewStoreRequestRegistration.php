<?php

namespace App\Listeners;

use App\Events\NewStoreRequestRegistration;
use App\Jobs\SendItemLine;
use App\Jobs\SendItemMail;
use App\Jobs\SendItemSMS;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use stdClass;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class TriggerNewStoreRequestRegistration
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * @throws ConfigurationException
     */
    public function handle(NewStoreRequestRegistration $event): void
    {
        switch ($event->notificationChannel){
            case 1:
                SendItemLine::dispatch("{$event->notificationTitle} - {$event->notificationContent}",$event->notificationAddress);
                break;
            case 2:
                SendItemMail::dispatch($event->notificationAddress, $event->notificationContent, $event->notificationTitle);
                break;
            case 3:
                $account_sid = getenv("TWILIO_SID");
                $auth_token = getenv("TWILIO_AUTH_TOKEN");
                $client = new Client($account_sid, $auth_token);
                $user = new stdClass();
                $user->address = $event->notificationAddress;
                SendItemSMS::dispatch($client,"{$event->notificationAddress} - {$event->notificationContent}",$user);
                break;
        }
    }
}
