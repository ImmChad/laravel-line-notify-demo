<?php

namespace App\Repository;

use App\Models\NotificationType;

class NotificationTypeRepository
{
    /**
     * @param int $id
     *
     * @return NotificationType
     */
    public function getDetail(int $id): NotificationType
    {
        return NotificationType::where('id', $id)->first();
    }
}
