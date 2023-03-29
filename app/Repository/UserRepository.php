<?php

namespace App\Repository;

use App\Models\NotificationUserInfo;
use App\Models\NotificationUserSettings;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    /**
     * @param String $userId
     * @param array $attributes
     * @return int
     */
    function updateNotificationUserInfo(String $userId, array $attributes): int
    {
        return DB::table('notification_user_info')->
        where(['id'=> $userId])
            ->update(
                $attributes
            );
    }

    /**
     * @param String $userId
     * @param array $attributes
     * @return int
     */
    function updateNotificationUserSetting(String $userId, array $attributes): int
    {
        return DB::table('notification_user_settings')->
        where([
            'user_id'=>$userId,
        ])->update($attributes);
    }


}
