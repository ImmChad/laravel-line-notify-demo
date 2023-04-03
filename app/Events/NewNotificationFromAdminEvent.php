<?php

namespace App\Events;

use App\Repository\NotificationDraftRepository;
use App\Repository\NotificationRepository;
use App\Services\NotificationService;
use App\Services\NotificationUserService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotificationFromAdminEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    /**
     * @param int $notificationId
     * @param NotificationRepository $notificationRepository
     * @param NotificationDraftRepository $notificationDraftRepository
     * @param NotificationService $notificationService
     */
    public function __construct
    (
        public int                         $notificationId,
        public NotificationRepository      $notificationRepository,
        public NotificationDraftRepository $notificationDraftRepository,
        public NotificationService         $notificationService,
        public NotificationUserService     $notificationUserService,
    )
    {
    }
}
