<?php

namespace App\Repository;

use App\Models\Notification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class NotificationRepository
{
    /**
     * @param int $id
     *
     * @return Notification
     */
    public function getDetail(int $id): Notification
    {
        return DB::table('notification')->where('id', $id)->first();
    }

    /**
     * @param string $textSearch
     * @return Collection
     */
    public function getNotificationBySearch(string $textSearch): Collection
    {
        return Notification::where('type', '!=', 1)
            ->where('announce_title', 'like', "%{$textSearch}%")
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * @param array $attribute
     *
     * @return int
     */
    public function insertDataNotification(array $attribute): int
    {
        return Notification::insertGetId($attribute);
    }

    /**
     * @param object $request
     *
     * @return int
     */
    function updateNotificationForListUser(object $request): int
    {
        return Notification::where('id', $request->announce_id)
            ->update(['announce_title' => $request->title, 'announce_content' => $request->message]);
    }

    /**
     * @param int $notificationId
     *
     * @return int
     */
    public function deleteNotification(int $notificationId): int
    {
        return Notification::where('id', $notificationId)->update(['deleted_at' => date('Y/m/d H:i:s')]);
    }
}
