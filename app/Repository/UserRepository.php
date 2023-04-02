<?php

namespace App\Repository;

use App\Handler\UserHandler;
use App\Models\NotificationUserInfo;
use App\Models\NotificationUserSettings;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;

class UserRepository
{
    /**
     * @param string $userId
     * @param array $attributes
     * @return int
     */
    function updateNotificationUserInfo(string $userId, array $attributes): int
    {
        return DB::table('notification_user_info')->
        where(['id' => $userId])
            ->update(
                $attributes
            );
    }

    /**
     * @param string $userId
     * @param array $attributes
     * @return int
     */
    function updateNotificationUserSetting(string $userId, array $attributes): int
    {
        return DB::table('notification_user_settings')->
        where([
            'user_id' => $userId,
        ])->update($attributes);
    }

    /**
     * @param string $id
     * @param array $attributes
     * @return int
     */
    function updateUserWithId(string $id, array $attributes): int
    {
        return DB::table("user")->where('id', $id)->update($attributes);
    }

    /**
     * @param string $userId
     * @param $lineId
     * @return bool
     */
    function insertNotificationUserLine(string $userId, $lineId): bool
    {
        $time = date('Y/m/d H:i:s');
        $id = Str::uuid()->toString();
        $dataUserLine = DB::table("notification_user_line")->where("user_id", $userId)->first();
        if (!isset($dataUserLine)) {
            return DB::table("notification_user_line")->insert(
                [
                    "id" => $id,
                    "user_id" => $userId,
                    "line_id" => $lineId,
                    "created_at" => $time
                ]
            );
        } else {
            return 0;
        }

    }

    public function updateEmailUserCaseConnectMail(string $id, string $email)
    {
        return DB::table("user")->where("id", $id)->update(
            [
                "email" => Crypt::encryptString($email)
            ]
        );
    }

    public function updateEmailStoreCaseConnectMail(string $id, string $email)
    {
        return DB::table("store")->where("user_id", $id)->update(
            [
                "mail_address" => Crypt::encryptString($email)
            ]
        );
    }

    /**
     * @param int $notificationId
     * @param string $userId
     * @return bool
     */
    public function insertNotificationRead(int $notificationId, string $userId): bool
    {
        $notificationIsRead = DB::table('notification_read')
            ->where(['notification_id' => $notificationId,
                'user_id' => $userId,
            ])->first();
        if (!isset($notificationIsRead)) {
            return DB::table('notification_read')
                ->insert(['notification_id' => $notificationId,
                    'user_id' => $userId,
                    'read_at' => now()]);
        }
        return false;

    }

    /**
     * @param string $userCreatedAt
     * @return Collection
     */
    public function getNotificationExceptNewRegisterBefore(string $userCreatedAt): Collection
    {
        return DB::table('notification')
            ->where('created_at', '>=', $userCreatedAt)
            ->where('is_sent', '!=', null)
            ->where('is_sent', '!=', false)
            ->where('deleted_at', '=', null)
            ->orderByDesc('id')
            ->get();
    }

    /**
     * @param int $notificationId
     * @param string $userId
     * @return Collection|null
     */
    public function getNotificationReadWithUserIdNotificationId(int $notificationId, string $userId): Collection|null
    {
        return DB::table('notification_read')
            ->where(['notification_id' => $notificationId])
            ->where(['user_id' => $userId])
            ->get(
                array(
                    'read_at'
                )
            );
    }

    /**
     * @param $id
     * @param $created_at
     * @return stdClass
     */
    public function getNotificationBeforeUserCreatedAtWithId($id, $created_at): stdClass
    {
        return DB::table('notification')
            ->where('created_at', '>=', $created_at)
            ->where('id', '=', $id)
            ->first();
    }
}
