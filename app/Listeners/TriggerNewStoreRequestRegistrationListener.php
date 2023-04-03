<?php

namespace App\Listeners;

use App\Events\NewStoreRequestRegistrationEvent;
use App\Jobs\SendItemLine;
use App\Jobs\SendItemMail;
use App\Jobs\SendItemSMS;
use App\Models\User;
use App\Repository\NotificationRepository;
use App\Repository\NotificationUserLineRepository;
use App\Services\NotificationService;
use App\Services\NotificationUserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use stdClass;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class TriggerNewStoreRequestRegistrationListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private NotificationRepository $notificationRepository)
    {
        //
    }

    /**
     * Handle the event.
     * @throws ConfigurationException
     */
    public function handle(NewStoreRequestRegistrationEvent $event): void
    {
        // config client to send sms
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $client = new Client($account_sid, $auth_token);


        $notificationUserService = new NotificationUserService(null, new NotificationUserLineRepository(), null);
        $lineList = $notificationUserService->getUserHasLine();
        $mailList = $notificationUserService->getUserNotLineHasMail();
        $smsList = $notificationUserService->getUserOnlyHasPhoneNumber();

        foreach ($event->newStories as $newStore) {
            $temp = explode('||', $newStore);
            $storeName = $temp[0];
            $storeId = $temp[1];

            $titleSubject = "New Store [ ".$storeName. " ]";
            $textNotification = 'Girlmee would like to notify you that a new store <'.$storeName.'> has been confirmed on the Girlmee system within the last 24 hours.{br}';
            $textNotification .= 'To view details about the store, please click on this link: ';
            $textNotification .= 'https://girlmee.com/store/'.$storeId;
            $textNotification .= '{br}Best regards,';

            $this->notificationRepository->insertDataNotification([
                'type' => 1,
                'announce_title' => $titleSubject,
                'announce_content' => $textNotification,
                'created_at' => date('Y/m/d H:i:s'),
                'is_sent' => true,
                'is_scheduled' => false,
                'scheduled_at' => null
            ]);

            $textForSmsLine = str_replace("{br}", "\r\n", $textNotification);
            $textForEmail = str_replace("{br}", "<br>", $textNotification);
            $mess = "{$titleSubject} \r\n \r\n {$textForSmsLine}";

            foreach($lineList as $lineId)
            {
                SendItemLine::dispatch($mess, $lineId->lineId);
            }

            foreach($mailList as $email)
            {
                SendItemMail::dispatch($email->email, $textForEmail, $titleSubject);
            }

            foreach($smsList as $sms)
            {
                 SendItemSMS::dispatch($client, $mess, $sms->phone_number_landline);

            }

        }

    }
}
