<?php

namespace App\Repository;

use App\Models\NotificationRead;
use Illuminate\Support\Collection;


class NotificationReadRepository
{
    /**
     * @param string $userId
     * @param int $notificationId
     *
     * @return Collection
     */
    public function getNotificationRead(string $userId, int $notificationId): Collection
    {
        return NotificationRead::where('user_id', $userId)
            ->where('notification_id', $notificationId)
            ->get();
    }
}
