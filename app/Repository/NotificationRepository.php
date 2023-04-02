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
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;
use PhpParser\Node\Scalar\String_;
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
     * @param String $id
     * @return Collection
     */
    public function listConnectLine(String $id): Collection
    {
        return DB::table('notification_user_line')->where('user_id', $id)->get();
    }

    /**
     * @param String $userId
     * @return Collection
     */
    public function getSeekerNameByUserId(String $userId) : Collection
    {
        return DB::table('seeker')->where(['user_id' => $userId])->get();
    }

    /**
     * @param String $userId
     * @return String
     */
    public function getStoreNameByUserId(String $userId) : Collection
    {
        return DB::table('store')->where(['user_id' => $userId])->get();
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
     * @param int $id
     * @return Collection|array
     */
    public function getUsersCreatedBeforeNotificationCurrent(int $id) : Collection | array
    {
        $dataNotification = self::getDataNotificationWithCreatedAt($id);
        $dataNotificationDraft = self::getNotificationDraftWithID($dataNotification->notification_draft_id);
        if($dataNotificationDraft->notification_for == "user")
        {
            return self::getAllUserIdSeekerWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id, $dataNotificationDraft->created_at);

        }
    else if($dataNotificationDraft->notification_for == "store")
        {
            return self::getAllUserIdStoreWithAreaIDIndustryIDCreatedAt($dataNotificationDraft->area_id, $dataNotificationDraft->industry_id, $dataNotificationDraft->created_at);
        }
    else
    {
        return  [];
    }
    }

    /**
     * @param int $id
     * @return stdClass
     */
    public function getDataNotificationWithCreatedAt(int $id) : stdClass
    {
        return DB::table("notification")->where("id", $id)->first();
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
     * @param array $attribute
     * @return int
     */
    public function insertNotificationNewStoreRegistration(array $attribute): int
    {
        return DB::table('notification')->insert(
            $attribute
        );
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function insertDataNotification(array $attribute): int
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        return Notification::insertGetId($attribute);
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
        return NotificationTemplate::where(['id' => $templateId])
            ->get();
    }

    /**
     * @param object $request
     * @return int
     */
    public function addNewTemplate(object $request) : int
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return NotificationTemplate::insert([
                'id' => Str::uuid()->toString(),
                'template_type' => $request->templateType,
                'template_name' => $request->templateName,
                'template_title' => $request->templateTitle,
                'template_content' => $request->templateContent,
                'created_at' => date('Y/m/d H:i:s')
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
                'template_name' => $request->templateName,
                'template_title' => $request->templateTitle,
                'template_content' => $request->templateContent,
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
     * @param String $notificationSender
     * @return Collection
     */
    public function getTemplateByTemplateType(String $notificationSender) : Collection
    {
        return NotificationTemplate::where(['template_type' => $notificationSender])
            ->get(
                array(
                    'id',
                    'template_type',
                    'template_name',
                    'template_title',
                    'template_content',
                    'created_at'
                )
            );
    }

    /**
     * @param int $regionId
     * @return Collection
     */
    public function getRegionCdFromRegionId(int $regionId) : Collection
    {
        return DB::table('static_region')
            ->where('id', $regionId)
            ->get(
                array(
                    'region_cd'
                )
            );
    }

    /**
     * @param int $regionId
     * @return Collection
     */
    public function getPrefFromRegionCd(int $regionCd) : Collection
    {
        return DB::table('static_pref')
            ->where('region_cd', $regionCd)
            ->get(
                array(
                    'id',
                    'region_cd',
                    'pref_name',
                    'created_at',
                    'update_at',
                    'pref_cd',
                    'pref_name_latin'
                )
            );
    }

    /**
     * @param int $prefId
     * @return Collection
     */
    public function getAreaFromRegionId(int $prefId) : Collection
    {
        return DB::table('static_area')
            ->where('pref_cd', $prefId)
            ->get(
                array(
                    'id',
                    'area_cd',
                    'area_name',
                    'pref_cd',
                    'created_at',
                    'updated_at',
                    'area_name_jp'
                )
            );
    }

    /**
     * @param object $request
     * @return Collection
     */
    public function getListUserRole2ById(object $request) : Collection
    {
        $areaId = $request->areaId;
        $industryId = $request->industryId;
        return DB::table(DB::raw("user, seeker_expect_location sel, seeker_expect_industry sei"))
            ->select(DB::raw('user.id, user.email, user.phone_number_landline'))
            ->where(function($query) use ($areaId, $industryId){
                if(intval($areaId) > 0)
                {
                    $query->where('sel.area_id', '=', intval($areaId));
                    $query->whereRaw("user.id = sel.user_id");
                }
                if(intval($industryId) > 0)
                {
                    $query->where('sei.industry_id', '=', intval($industryId));
                    $query->whereRaw("user.id = sei.user_id");
                }
            })
            ->where('user.role', '=', 2)
            ->get();
    }

    /**
     * @param object $request
     * @return Collection
     */
    public function getListUserRole3ById(object $request) : Collection
    {
        $areaId = $request->areaId;
        $industryId = $request->industryId;

        return DB::table(DB::raw('user, store'))
            ->select(DB::raw('user.id, store.mail_address, store.phone_number'))
            ->where(function($query) use ($areaId, $industryId){
                if(intval($areaId) > 0)
                {
                    $query->where('store.area_cd', '=', intval($areaId));
                }
                if(intval($industryId) > 0)
                {
                    $query->where('store.business_type_id', '=', intval($industryId));
                }
            })
            ->whereRaw("user.id = store.user_id")
            ->where('user.role', '=', 3)
            ->get();
    }

    /**
     * @return Collection
     */
    public function getListUserAllRole2() : Collection
    {
        return DB::table('user')->where('role', '=', 2)->get();
    }

    /**
     * @return Collection
     */
    public function getListUserAllRole3() : Collection
    {
        return DB::table(DB::raw('user, store'))
            ->select(DB::raw('user.id, store.mail_address, store.phone_number'))
            ->where('role', '=', 3)
            ->whereRaw("user.id = store.user_id")
            ->get();
    }

    /**
     * @param String $id
     * @return Collection
     */
    public function getListUserLine(String $id) : Collection
    {
        return DB::table('notification_user_line')->where('user_id', $id)->get();
    }

    public function getAllUserIdUserLine(): Builder
    {
        return DB::table('notification_user_line')->select("user_id");
    }
    /**
     * @param object $request
     * @param int $totalUserLine
     * @param int $totalUserMail
     * @param int $totalUserSms
     * @return int
     */
    public function saveNotificationDraft(object $request, int $totalUserLine, int $totalUserMail, int $totalUserSms) : int
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $isScheduled = $request->delayTime > 0;
        $scheduledAt = $isScheduled ? now()->addSeconds(intval($request->delayTime)) : null;
        $now = date('Y/m/d H:i:s');
        $totalUserSms = 0;
        $totalUserLine = 0;
        $totalUserMail = 0;

        if($request->announceFor == "user")
        {
            $totalUserSms = count($this->getSeekerOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
            $totalUserMail = count($this->getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
            $totalUserLine = count($this->getSeekerHasLineWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
        }
        else if($request->announceFor == "store")
        {
            $totalUserSms = count($this->getStoreOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
            $totalUserMail = count($this->getStoreNotLineHasMailWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
            $totalUserLine = count($this->getStoreHasLineWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
        }

        return DB::table('notification_draft')->insertGetId([
            'id' => Str::uuid()->toString(),
            'notification_for' => $request->announceFor,
            'notification_title' => $request->title,
            'notification_content' => $request->message,
            'area_id' => $request->areaId,
            'industry_id' => $request->industryId,
            'sms_user' => $totalUserSms,
            'line_user' => $totalUserLine,
            'mail_user' =>$totalUserMail,
            'created_at' => $now,
            'scheduled_at' => $scheduledAt,
        ]);
    }

    public function updateNotificationDraft(object $request, int $totalUserLine, int $totalUserMail, int $totalUserSms) : int
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $isScheduled = $request->delayTime > 0;
        $scheduledAt = $isScheduled ? now()->addSeconds(intval($request->delayTime)) : null;
        $totalUserSms = 0;
        $totalUserLine = 0;
        $totalUserMail = 0;
        $now = date('Y/m/d H:i:s');
        if($request->announceFor == "user")
        {
            $totalUserSms = count($this->getSeekerOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
            $totalUserMail = count($this->getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
            $totalUserLine = count($this->getSeekerHasLineWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
        }
        else if($request->announceFor == "store")
        {
            $totalUserSms = count($this->getStoreOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
            $totalUserMail = count($this->getStoreNotLineHasMailWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
            $totalUserLine = count($this->getStoreHasLineWithAreaIDIndustryIDCreatedAt($request->areaId,$request->industryId,$now));
        }

        return DB::table('notification_draft')
        ->where('id', $request->notification_draft_id)
        ->update([
            'notification_for' => $request->announceFor,
            'notification_title' => $request->title,
            'notification_content' => $request->message,
            'area_id' => $request->areaId,
            'industry_id' => $request->industryId,
            'sms_user' => $totalUserSms,
            'line_user' => $totalUserLine,
            'mail_user' =>$totalUserMail,
            'updated_at' => $now,
            'scheduled_at' => $scheduledAt,
        ]);
    }

    public function removeNotificationDraft(Request $request) : int
    {
        return DB::table('notification_draft')->where(["id"=>$request->notification_draft_id])->update(["is_processed"=>1]);
    }

    public function getNotificationDraft() : Collection
    {
        return DB::table('notification_draft')->get();
    }
    public function getNotificationDraftForSend() : Collection
    {
        return DB::table('notification_draft')->get();
    }
    public function getNotificationDraftForSummaryView() :stdClass|null
    {
        $dataDraft = DB::table('notification_draft')->where(['is_processed'=>0])->orderBy('created_at','DESC')->get()->first();
        if(isset($dataDraft))
        {
            if($dataDraft->notification_for == "user")
            {
                $dataDraft->lineUsers = self::getSeekerHasLineWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
                $dataDraft->emailUsers = self::getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
                $dataDraft->smsUsers = self::getSeekerOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
            }
            else if($dataDraft->notification_for == "store")
            {
                $dataDraft->lineUsers = self::getStoreHasLineWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
                $dataDraft->emailUsers = self::getStoreNotLineHasMailWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
                $dataDraft->smsUsers = self::getStoreOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
            }
        }


        return $dataDraft;
    }

    public function getNotificationDraftWithID($notificationDraftId)  :stdClass|null
    {
        return DB::table('notification_draft')->where(["id"=>$notificationDraftId])->orderBy('created_at','DESC')->get()->first();
    }
    public function getAllUserIdSeekerWithAreaIDIndustryIDCreatedAt(int $areaId, int $industryId, String $created_at)
    {
        $nameTableSeekerLocation = ($areaId > 0?', seeker_expect_location sel':'');
        $nameTableSeekerIndustry = ($industryId > 0?', seeker_expect_industry sei':'');
        return DB::table(DB::raw("user {$nameTableSeekerLocation} {$nameTableSeekerIndustry}"))
            ->select(DB::raw('user.id'))
            ->where(function($query) use ($areaId, $industryId){
                if($areaId > 0)
                {
                    $query->where('sel.area_id', '=', $areaId);
                    $query->whereRaw("user.id = sel.user_id");
                }
                if($industryId > 0)
                {
                    $query->where('sei.industry_id', '=', $industryId);
                    $query->whereRaw("user.id = sei.user_id");
                }
            })
            ->where('user.role', '=', 2)
            ->where('user.created_at', '<=', $created_at)
            ->distinct()
            ->get();
    }

    public function getAllUserIdStoreWithAreaIDIndustryIDCreatedAt(int $areaId, int $industryId, String $created_at)
    {

        return DB::table(DB::raw("store, user"))
            ->select(DB::raw('user.id, store.id as store_id'))
            ->where(function($query) use ($areaId, $industryId){
                if($areaId > 0)
                {
                    $query->where('store.area_cd', '=', $areaId);
                }
                if($industryId > 0)
                {
                    $query->where('store.business_type_id', '=', $industryId);
                }
            })
            ->where('user.created_at', '<=', $created_at)
            ->where('role', '=', 3)
            ->whereRaw("user.id = store.user_id")
            ->distinct()
            ->get();


    }

    public function getStoreHasLineWithAreaIDIndustryIDCreatedAt(int $areaId, int $industryId, String $created_at): Collection
    {
        $allUserLine = self::getAllUserIdUserLine()   ;
        DB::enableQueryLog();
        $stores =
            DB::table(DB::raw('user, store'))
                ->select(DB::raw('store.id, store.store_name, store.phone_number, store.mail_address'))
                ->where(function($query) use ($areaId, $industryId){
                    if($areaId > 0)
                    {
                        $query->where('store.area_cd', '=', $areaId);
                    }
                    if($industryId > 0)
                    {
                        $query->where('store.business_type_id', '=', $industryId);
                    }
                })
                ->where('user.created_at', '<=', $created_at)
                ->where('role', '=', 3)
                ->whereIn('user.id',$allUserLine)
                ->whereRaw("user.id = store.user_id")
                ->distinct()
                ->get();
        return $stores->map(function ($store)
        {
            $userId = self::getUserIdByStoreId($store->id);
            $store->lineId = self::getLineIdWithUserId($userId->user_id);
            $notification = new NotificationService($this);
            return $store;
        });
    }

    /**
     * @param String $storeId
     * @return Collection|stdClass|array
     */
    public function getUserIdByStoreId(String $storeId) : Collection|stdClass|array
    {
        return DB::table('store')->where('id', $storeId)->get()->first();
    }

    public function getLineIdWithUserId(String $userId)
    {
            $dataLine = DB::table("notification_user_line")->where("user_id", $userId)->get("line_id")->first();
            if(isset($dataLine))
            {
                return $dataLine->line_id;
            }
            return null;
    }

    public function getStoreNotLineHasMailWithAreaIDIndustryIDCreatedAt(int $areaId, int $industryId, String $created_at): Collection
    {
        $allUserLine = self::getAllUserIdUserLine();
        $stores =
            DB::table(DB::raw('user, store'))
                ->select(DB::raw('store.id, store.store_name, store.phone_number, store.mail_address'))
                ->where(function($query) use ($areaId, $industryId){
                    if($areaId > 0)
                    {
                        $query->where('store.area_cd', '=', intval($areaId));
                    }
                    if($industryId > 0)
                    {
                        $query->where('store.business_type_id', '=', intval($industryId));
                    }
                })
                ->whereNotNull('store.mail_address')
                ->whereRaw("LENGTH(TRIM(store.mail_address)) > 0")
                ->where('user.created_at', '<=', $created_at)
                ->where('role', '=', 3)
                ->whereRaw("user.id = store.user_id")
                ->whereNotIn('user.id',$allUserLine)
                ->distinct()
                ->get();

        return $stores->map(function ($store) use ($industryId, $areaId) {
            $store->emailDecrypted = Crypt::decryptString($store->mail_address);

            return $store;
        });
    }

    public function getStoreOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt(int $areaId, int $industryId, String $created_at): Collection
    {
        $allUserLine = self::getAllUserIdUserLine()   ;
        $stores =
            DB::table(DB::raw('user, store'))
                ->select(DB::raw('store.id, store.store_name, store.phone_number, store.mail_address'))
                ->where(function($query) use ($areaId, $industryId){
                    if($areaId > 0)
                    {
                        $query->where('store.area_cd', '=', intval($areaId));
                    }
                    if($industryId > 0)
                    {
                        $query->where('store.business_type_id', '=', intval($industryId));
                    }
                })
                ->whereNull("store.mail_address")
                ->whereNotNull('store.phone_number')
                ->whereRaw("LENGTH(TRIM(store.phone_number)) > 0")
                ->where('user.created_at', '<=', $created_at)
                ->where('role', '=', 3)
                ->whereRaw("user.id = store.user_id")
                ->whereNotIn('user.id',$allUserLine)
                ->distinct()
                ->get();
        return $stores->map(function ($store)
        {
            $store->phoneNumberDecrypted = Crypt::decryptString($store->phone_number);
//            $store->phoneNumberDecrypted = Crypt::decryptString($store->phone_number);
            return $store;
        });
    }
    public function getSeekerWithUserId(String $userId)
    {
        return DB::table('seeker')->where(['user_id'=>$userId])->get()->first();
    }
    /**
     * @param int $areaId
     * @param int $industryId
     * @param String $created_at
     * @return Collection
     */
    public function getSeekerHasLineWithAreaIDIndustryIDCreatedAt(int $areaId, int $industryId, String $created_at): Collection
    {
        $allUserLine = self::getAllUserIdUserLine()   ;
        $nameTableSeekerLocation = ($areaId > 0?', seeker_expect_location sel':'');
        $nameTableSeekerIndustry = ($industryId>0?', seeker_expect_industry sei':'');
        $seekers = DB::table(DB::raw("user {$nameTableSeekerLocation} {$nameTableSeekerIndustry}"))
        ->select(DB::raw('user.id, user.email, user.phone_number_landline'))
        ->where(function($query) use ($areaId, $industryId){
            if($areaId > 0)
            {
                $query->where('sel.area_id', '=', $areaId);
                $query->whereRaw("user.id = sel.user_id");
            }
            if($industryId > 0)
            {
                $query->where('sei.industry_id', '=', $industryId);
                $query->whereRaw("user.id = sei.user_id");
            }
        })
        ->where('user.role', '=', 2)
        ->whereIn('user.id',$allUserLine)
        ->where('user.created_at', '<=', $created_at)
        ->distinct()
        ->get();
        return $seekers->map(function ($seeker)
        {
            $seeker->lineId = self::getLineIdWithUserId($seeker->id);
            $dataSeeker = self::getSeekerWithUserId($seeker->id);
            if(isset($dataSeeker))
            {
                $seeker->nickname = $dataSeeker->nickname;
                $seeker->realname = $dataSeeker !== null ?Crypt::decryptString($dataSeeker->realname):null;
            }
            else
            {
                $seeker->nickname = "";
            }



            return $seeker;
        });
    }

    /**
     * @param int $areaId
     * @param int $industryId
     * @param String $created_at
     * @return mixed
     */
    public function getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt(int $areaId, int $industryId, String $created_at)
    {
        $allUserLine = self::getAllUserIdUserLine()   ;
        $nameTableSeekerLocation = ($areaId > 0?', seeker_expect_location sel':'');
        $nameTableSeekerIndustry = ($industryId>0?', seeker_expect_industry sei':'');
        $seekers = DB::table(DB::raw("user {$nameTableSeekerLocation} {$nameTableSeekerIndustry}"))
            ->select(DB::raw('user.id, user.email, user.phone_number_landline'))
            ->where(function($query) use ($areaId, $industryId){
                if($areaId > 0)
                {
                    $query->where('sel.area_id', '=', $areaId);
                    $query->whereRaw("user.id = sel.user_id");
                }
                if($industryId > 0)
                {
                    $query->where('sei.industry_id', '=', $industryId);
                    $query->whereRaw("user.id = sei.user_id");
                }
            })
            ->whereNotNull('user.email')
            ->whereRaw("LENGTH(TRIM(user.email)) > 0")
            ->where('user.role', '=', 2)
            ->where('user.created_at', '<=', $created_at)
            ->whereNotIn('user.id',$allUserLine)
            ->distinct()
            ->get();
        return $seekers->map(function ($seeker)
        {
            $dataSeeker = self::getSeekerWithUserId($seeker->id);
            if(isset($dataSeeker))
            {
                $seeker->nickname = $dataSeeker->nickname;
                $seeker->realname = $dataSeeker !== null ?Crypt::decryptString($dataSeeker->realname):null;
            }
            else
            {
                $seeker->nickname = "";
            }
            $seeker->emailDecrypted = Crypt::decryptString($seeker->email);
//            $notificationSv = new NotificationService(($this));
//
//            $notificationSv->loadParamNotificationUser("{prefecture_nm}", $seeker->id);

            return $seeker;
        });
    }

    /**
     * @param int $areaId
     * @param $industryId
     * @param String $created_at
     * @return mixed
     */
    public function getSeekerOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt(int $areaId, $industryId, String $created_at)
    {
        $allUserLine = self::getAllUserIdUserLine()   ;
        $nameTableSeekerLocation = ($areaId > 0?', seeker_expect_location sel':'');
        $nameTableSeekerIndustry = ($industryId>0?', seeker_expect_industry sei':'');
        $seekers = DB::table(DB::raw("user {$nameTableSeekerLocation} {$nameTableSeekerIndustry}"))
            ->select(DB::raw('user.id, user.email, user.phone_number_landline'))
            ->where(function($query) use ($areaId, $industryId){
                if($areaId > 0)
                {
                    $query->where('sel.area_id', '=', $areaId);
                    $query->whereRaw("user.id = sel.user_id");
                }
                if($industryId > 0)
                {
                    $query->where('sei.industry_id', '=', $industryId);
                    $query->whereRaw("user.id = sei.user_id");
                }
            })
            ->whereNull('user.email')
            ->whereNotNull("user.phone_number_landline")
            ->whereRaw("LENGTH(TRIM(user.phone_number_landline)) > 0")
            ->where('user.role', '=', 2)
            ->where('user.created_at', '<=', $created_at)
            ->whereNotIn('user.id',$allUserLine)
            ->distinct()
            ->get();
        return $seekers->map(function ($seeker)
        {
            $dataSeeker = self::getSeekerWithUserId($seeker->id);
            if(isset($dataSeeker))
            {
                $seeker->nickname = $dataSeeker->nickname;
                $seeker->realname = $dataSeeker !== null ?Crypt::decryptString($dataSeeker->realname):null;
            }
            else
            {
                $seeker->nickname = "";
            }
            $seeker->phoneNumberDecrypted = Crypt::decryptString($seeker->phone_number_landline);
            return $seeker;
        });
    }


    /**
     * @return Collection
     */
    public function getAllUser() : Collection
    {
        return DB::table('user')->get();
    }

    /**
     * @return Collection
     */
    public function getTemplate() : Collection
    {
        return DB::table('notification_template')
            ->orderBy('created_at', 'desc')
            ->get(
                array(
                    'id',
                    'template_type',
                    'template_name',
                    'template_title',
                    'template_content',
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
                    'region_name',
                    'region_cd',
                    'region_name_jp'
                )
            );
    }

    /**
     * @return Collection
     */
    public function getArea() : Collection
    {
        return DB::table('static_area')
            ->get(
                array(
                    'id',
                    'area_cd',
                    'area_name',
                    'pref_cd',
                    'created_at',
                    'updated_at',
                    'area_name_jp'
                )
            );
    }

    /**
     * @return Collection
     */
    public function getIndustry() : Collection
    {
        return DB::table('static_industry')
            ->get(
                array(
                    'id',
                    'industry_name',
                    'industry_name_jp'
                )
            );
    }

    /**
     * @return Collection
     */
    public function getParamUser() : Collection
    {
        return DB::table('param_user')
            ->get(
                array(
                    'id',
                    'value'
                )
            );
    }

    /**
     * @return Collection
     */
    public function getParamStore() : Collection
    {
        return DB::table('param_store')
            ->get(
                array(
                    'id',
                    'value'
                )
            );
    }

    /**
     * @param String $notificationId
     * @return int
     */
    public function cancelNotificationDraft(String $notificationId): int
    {
        return DB::statement("DELETE FROM notification_draft WHERE id = '{$notificationId}' ");
    }
    public function getFirstStoreWithUserID(String $userId)
    {
        return DB::table('store')->where("user_id",$userId)->first();
    }
}
