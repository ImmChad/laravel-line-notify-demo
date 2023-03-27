<?php

namespace App\Repository;

use App\Http\Controllers\User\UserController;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\NotificationRead;
use App\Models\NotificationTemplate;
use App\Models\NotificationType;
use App\Models\NotificationUserInfo;
use App\Models\NotificationUserSettings;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;
use function Webmozart\Assert\Tests\StaticAnalysis\object;

class NotificationRepository
{
    /**
     * @param array $request
     * @return Collection
     */
    public function handleSubmitLogin(array $request) :Collection
    {
        $password = $request['password'];
        $username = $request['username'];
        return Admin::where([
            'password' => $password,
            'username' => $username
        ])->get();
    }


    /**
     * @param int $notificationId
     *
     * @return Collection
     */
    public function getContentUpdateNotificationToView(int $notificationId): Collection
    {
        return Notification::where('id', $notificationId)
            ->get(
                array(
                    'id',
                    'type',
                    'announce_title',
                    'announce_content',
                )
            );
    }

    /**
     * @return Collection
     */
    public function listConnectLine(): Collection
    {
        return NotificationUserSettings::where(['notification_channel_id' => UserController::CHANNEL_LINE])
            ->get(
                array(
                    'id',
                    'user_id',
                    'notification_channel_id',
                    'created_at',
                    'address'
                )
            );
    }

    /**
     * @param String $userId
     * @return String
     */
    public function getUserNameByUserId(String $userId) : String
    {
        return NotificationUserInfo::where(['id' => $userId])->get()[0]->displayName;
    }

    /**
     * @param String $textSearch
     * @return Collection
     */
    public function getNotificationBySearch(String $textSearch) : Collection
   {
       return Notification::where('type', '!=', 1)
           ->where('announce_title', 'like', "%{$textSearch}%")
           ->orderBy('created_at', 'DESC')
           ->get();
   }

    /**
     * @param int $notificationType
     * @return Collection
     */
    public function getNotificationTypeById(int $notificationType) : Collection
   {
       return NotificationType::where('id', $notificationType)->get();
   }

    /**
     * @param String $createdAt
     * @return Collection
     */
    public function getUsersCreatedBeforeNotificationCurrent(String $createdAt) : Collection
    {
        return NotificationUserSettings::where('created_at', '<=', $createdAt)->get();
    }

    /**
     * @param String $createdAt
     * @return Collection
     */
    public function getUsersCreatedBeforeNotificationEmailCurrent(String $createdAt) : Collection
    {
        return NotificationUserSettings::where('created_at', '<=', $createdAt)
            ->where('notification_channel_id', 2)
            ->get();
    }



    /**
     * @param String $userId
     * @param int $notificationId
     * @return Collection
     */
    public function getNotificationRead(String $userId, int $notificationId) : Collection
    {
        return NotificationRead::where('user_id', $userId)
            ->where('notification_id', $notificationId)
            ->get();
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function insertDataNotification(object $request): int
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $isScheduled = $request->delayTime > 0;
        $isSent = !$isScheduled;
        $scheduledAt = $isScheduled ? now()->addSeconds(intval($request->delayTime)) : null;

        return Notification::insertGetId([
            'type' => $request->type_notification,
            'announce_title' => $request->title,
            'announce_content' => $request->message,
            'is_sent' => $isSent,
            'is_scheduled' => $isScheduled,
            'created_at' => date('Y/m/d H:i:s'),
            'scheduled_at' => $scheduledAt,
        ]);
    }

    /**
     * @param object $request
     * @return int
     */
    function updateNotificationForListUser(object $request): int
    {
        return Notification::where('id', $request->announce_id)
            ->update([
                'announce_title' => $request->title,
                'announce_content' => $request->message
            ]);
    }


    /**
     * @param int $status
     * @return Collection
     */
    public function getDataNotificationUserSetting(int $status): Collection
    {
        return NotificationUserSettings::where(['notification_channel_id' => $status])
            ->get(
                array(
                    'id',
                    'user_id',
                    'notification_channel_id',
                    'created_at',
                    'address'
                )
            );
    }

    /**
     * @param String $userId
     * @return Collection
     */
    public function getDataNotificationUserInfo(String $userId): Collection
    {
        return NotificationUserInfo::where(['id' => $userId])->get();
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getNotificationFromId(int $id) : Collection
    {
        return Notification::where(['id' => $id])
            ->get();
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getTypeNameFromTypeNotification(int $id) : Collection
    {
        return NotificationType::where('id', $id)->get();
    }


    /**
     * @param int $notification_id
     * @return int
     */
    public function deleteNotification(int $notification_id): int
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return Notification::where('id', $notification_id)
            ->update([
                'deleted_at' => date('Y/m/d H:i:s')
            ]);
    }

    /**
     * @param String $templateId
     * @return Collection
     */
    public function getTemplateFromId(String $templateId): Collection
    {
        return  NotificationTemplate::where(['id' => $templateId])
            ->get(
                array(
                    'id',
                    'template_name',
                    'template_title',
                    'template_content',
                    'region_id',
                    'area_id',
                    'industry_id',
                    'store_id',
                    'created_at',
                )
            );
    }

    /**
     * @param object $request
     * @return int
     */
    public function addNewTemplate(object $request) : int
    {
        return NotificationTemplate::insert([
                'created_at' => now(),
                'id' => Str::uuid()->toString(),
                'template_name' => $request->template_name,
                'template_title' => $request->template_title,
                'template_content' => $request->template_content,
                'region_id' => $request->region_id,
                'area_id' => $request->area_id,
                'industry_id' => $request->industry_id,
                'store_id' => $request->store_id,
            ]);
    }

    /**
     * @param object $request
     * @return int
     */
    public function updateTemplate(object $request) : int
    {
        return NotificationTemplate::where('id', $request->id)
            ->update([
                'created_at' => now(),
                'id' => Str::uuid()->toString(),
                'template_name' => $request->template_name,
                'template_title' => $request->template_title,
                'template_content' => $request->template_content,
                'region_id' => $request->region_id,
                'area_id' => $request->area_id,
                'industry_id' => $request->industry_id,
                'store_id' => $request->store_id,
            ]);
    }


    /**
     * @param String $templateId
     * @return Collection|stdClass|array
     */
    public function getTemplateForSendMail(String $templateId) : Collection|stdClass|array
    {
            return  NotificationTemplate::where('id', $templateId)
            ->get()->toArray();
    }





    /**
     * @return Collection
     */
    public function getTemplate() : Collection
    {
        return DB::table('notification_template')
            ->orderBy('id', 'desc')
            ->get(
                array(
                    'id',
                    'template_name',
                    'template_title',
                    'template_content',
                    'region_id',
                    'area_id',
                    'industry_id',
                    'store_id',
                    'created_at',
                )
            );
    }

    /**
     * @return Collection
     */
    public function getRegion() : Collection
    {
        return DB::table('static_region')
            ->get(
                array(
                    'id',
                    'region_name'
                )
            );
    }

    /**
     * @return Collection
     */
    public function getArea() : Collection
    {
        $data = DB::table('static_area')
            ->get(
                array(
                    'id',
                    'area_name'
                )
            );

        return $data;
    }

    /**
     * @return Collection
     */
    public function getIndustry() : Collection
    {
        $data = DB::table('static_industry')
            ->get(
                array(
                    'id',
                    'industry_name'
                )
            );

        return $data;
    }

    /**
     * @return Collection
     */
    public function getStore() : Collection
    {
        $data = DB::table('static_store')
            ->get(
                array(
                    'id',
                    'store_name'
                )
            );

        return $data;
    }
}
