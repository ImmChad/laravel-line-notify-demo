<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Seeker;
use App\Models\Store;

use App\Repository\NotificationDraftRepository;
use App\Repository\NotificationRepository;
use App\Repository\NotificationUserLineRepository;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Exception;

class NotificationUserService
{
    /**
     * @param NotificationRepository|null $notificationRepository
     * @param NotificationUserLineRepository|null $notificationUserLineRepository
     * @param NotificationDraftRepository|null $notificationDraftRepository
     */
    public function __construct(
        private ?NotificationRepository $notificationRepository,
        private ?NotificationUserLineRepository $notificationUserLineRepository,
        private ?NotificationDraftRepository $notificationDraftRepository
    )
    {
    }

    /**
     * @param int $id
     *
     * @return Collection|array
     */

    // old function name: getUserReadNotification
    public function getUserReadNotification(int $id): Collection|array
    {
        $dataNotification = DB::table("notification")->where("id", $id)->first();

        if($dataNotification->notification_draft_id == null)
        {
//            dump($dataNotification->notification_draft_id);
        }
        else
        {
            $dataNotificationDraft = $this->notificationDraftRepository
                ->getNotificationDraftWithID($dataNotification->notification_draft_id);
        }

//        dump($dataNotification->type);
//        dd($dataNotificationDraft);


        if (isset($dataNotificationDraft) && $dataNotification->type != 1) {
            if ($dataNotificationDraft->notification_for == "user") {
                return self::getAllUserIdSeekerByCriteria(
                    $dataNotificationDraft->area_id,
                    $dataNotificationDraft->industry_id,
                    $dataNotificationDraft->created_at
                );
            } else {
                if ($dataNotificationDraft->notification_for == "store") {
                    return self::getAllUserIdStoreWithAreaIDIndustryIDCreatedAt(
                        $dataNotificationDraft->area_id,
                        $dataNotificationDraft->industry_id,
                        $dataNotificationDraft->created_at
                    );
                }
            }
        } else {
            if ($dataNotification->type == 1) {
                $inforUser = Session::get('inforUser');
                $coll = collect();
                $coll->add((object)$inforUser);
                return $coll;
            }
            return new Collection();
        }
        return new Collection();
    }


    /**
     * @param int $areaId
     */
    public function getRegionIdByAreaId(int $areaId)
    {
        $pref = DB::table('static_area')->where('id', $areaId)->first();
        $regionCd = DB::table('static_pref')->where('pref_cd', $pref->pref_cd)->first();

        return DB::table('static_region')->where('region_cd', $regionCd->region_cd)->first();
    }

    /**
     * @param int $regionCd
     *
     * @return Collection
     */
    public function getPrefFromRegionCd(int $regionCd): Collection
    {
        return DB::table('static_pref')->where('region_cd', $regionCd)->get();
    }

    /**
     * @param int $prefId
     * @return Collection
     */
    public function getAreaFromRegionId(int $prefId): Collection
    {
        return DB::table('static_area')
            ->where('pref_cd', $prefId)
            ->get();
    }

    /**
     * @param object $request
     *
     * @return Collection
     */
    public function getListUserRole2ById(object $request): Collection
    {
        $areaId = $request->areaId;
        $industryId = $request->industryId;

        return DB::table(DB::raw("user, seeker_expect_location sel, seeker_expect_industry sei"))
            ->select(DB::raw('user.id, user.email, user.phone_number_landline'))
            ->where(function ($query) use ($areaId, $industryId) {
                if (intval($areaId) > 0) {
                    $query->where('sel.area_id', '=', intval($areaId));
                    $query->whereRaw("user.id = sel.user_id");
                }

                if (intval($industryId) > 0) {
                    $query->where('sei.industry_id', '=', intval($industryId));
                    $query->whereRaw("user.id = sei.user_id");
                }
            })
            ->where('user.role', '=', 2)
            ->get();
    }

    /**
     * @param object $request
     *
     * @return Collection
     */
    public function getListUserRole3ById(object $request): Collection
    {
        $areaId = $request->areaId;
        $industryId = $request->industryId;

        return DB::table(DB::raw('user, store'))
            ->select(DB::raw('user.id, store.mail_address, store.phone_number'))
            ->where(function ($query) use ($areaId, $industryId) {
                if (intval($areaId) > 0) {
                    $query->where('store.area_cd', '=', intval($areaId));
                }
                if (intval($industryId) > 0) {
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
    public function getListUserAllRole2(): Collection
    {
        return DB::table('user')->where('role', '=', 2)->get();
    }

    /**
     * @return Collection
     */
    public function getListUserAllRole3(): Collection
    {
        return DB::table(DB::raw('user, store'))
            ->select(DB::raw('user.id, store.mail_address, store.phone_number'))
            ->where('role', '=', 3)
            ->whereRaw("user.id = store.user_id")
            ->get();
    }


    /**
     * @param int $areaId
     * @param int $industryId
     * @param string $createdAt
     *
     * @return Collection
     */
    public function getAllUserIdSeekerByCriteria(int $areaId, int $industryId, string $createdAt): Collection
    {
        $nameTableSeekerLocation = ($areaId > 0 ? ', seeker_expect_location sel' : '');
        $nameTableSeekerIndustry = ($industryId > 0 ? ', seeker_expect_industry sei' : '');

        return DB::table(DB::raw("user {$nameTableSeekerLocation} {$nameTableSeekerIndustry}"))
            ->select(DB::raw('user.id'))
            ->where(function ($query) use ($areaId, $industryId) {
                if ($areaId > 0) {
                    $query->where('sel.area_id', '=', $areaId);
                    $query->whereRaw("user.id = sel.user_id");
                }
                if ($industryId > 0) {
                    $query->where('sei.industry_id', '=', $industryId);
                    $query->whereRaw("user.id = sei.user_id");
                }
            })
            ->where('user.role', '=', 2)
            ->where('user.created_at', '<=', $createdAt)
            ->distinct()
            ->get();
    }

    /**
     * @param int $areaId
     * @param int $industryId
     * @param string $createdAt
     *
     * @return Collection
     */
    public function getAllUserIdStoreWithAreaIDIndustryIDCreatedAt(int $areaId, int $industryId, string $createdAt): Collection
    {
        return DB::table(DB::raw("store, user"))
            ->select(DB::raw('user.id, store.id as store_id'))
            ->where(function ($query) use ($areaId, $industryId) {
                if ($areaId > 0) {
                    $query->where('store.area_cd', '=', $areaId);
                }
                if ($industryId > 0) {
                    $query->where('store.business_type_id', '=', $industryId);
                }
            })
            ->where('user.created_at', '<=', $createdAt)
            ->where('role', '=', 3)
            ->whereRaw("user.id = store.user_id")
            ->distinct()
            ->get();
    }

    /**
     * @param int $areaId
     * @param int $industryId
     * @param string $createdAt
     *
     * @return Collection
     */
    public function getStoreHasLineWithAreaIDIndustryIDCreatedAt(
        int $areaId,
        int $industryId,
        string $createdAt
    ): Collection {
        $allUserLine = $this->notificationUserLineRepository->getAllUserIdUserLine();
        DB::enableQueryLog();
        $stores =
            DB::table(DB::raw('user, store'))
                ->select(DB::raw('store.id, store.store_name, store.phone_number, store.mail_address'))
                ->where(function ($query) use ($areaId, $industryId) {
                    if ($areaId > 0) {
                        $query->where('store.area_cd', '=', $areaId);
                    }
                    if ($industryId > 0) {
                        $query->where('store.business_type_id', '=', $industryId);
                    }
                })
                ->where('user.created_at', '<=', $createdAt)
                ->where('role', '=', 3)
                ->whereIn('user.id', $allUserLine)
                ->whereRaw("user.id = store.user_id")
                ->distinct()
                ->get();

        return $stores->map(function ($store) {
            $userId = DB::table('store')->where('id', $store->id)->get()->first();
            $store->lineId = $this->notificationUserLineRepository->getLineIdWithUserId($userId->user_id);

            //$notification = new NotificationService($this);
            return $store;
        });
    }

    /**
     * @param string $storeId
     *
     * @return Store|null
     */
    public function getUserIdByStoreId(string $storeId): ?Store
    {
        return DB::table('store')->where('id', $storeId)->first();
    }

    /**
     * @param int $areaId
     * @param int $industryId
     * @param string $createdAt
     *
     * @return Collection
     */
    public function getStoreNotLineHasMailWithAreaIDIndustryIDCreatedAt(
        int $areaId,
        int $industryId,
        string $createdAt
    ): Collection {
        $allUserLine =  $this->notificationUserLineRepository->getAllUserIdUserLine();
        $stores =
            DB::table('user')
                ->join('store', 'user.id', '=', 'store.user_id')
                ->select(DB::raw('store.id, store.store_name, store.phone_number, store.mail_address'))
                ->where(function ($query) use ($areaId, $industryId) {
                    if ($areaId > 0) {
                        $query->where('store.area_cd', '=', intval($areaId));
                    }
                    if ($industryId > 0) {
                        $query->where('store.business_type_id', '=', intval($industryId));
                    }
                })
                ->whereNotNull('store.mail_address')
                ->whereRaw("LENGTH(TRIM(store.mail_address)) > 0")
                ->where('user.created_at', '<=', $createdAt)
                ->where('role', '=', 3)
                ->whereRaw("user.id = store.user_id")
                ->whereNotIn('user.id', $allUserLine)
                ->distinct()
                ->get();

        return $stores->map(function ($store) use ($industryId, $areaId) {

            $store->emailDecrypted = ($store->mail_address);
            try{
                $store->emailDecrypted = Crypt::decryptString($store->mail_address);
            }catch(Exception $ex){
            }

            return $store;
        });
    }

    /**
     * @param int $areaId
     * @param int $industryId
     * @param string $createdAt
     *
     * @return Collection
     */
    public function getStoreOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt(
        int $areaId,
        int $industryId,
        string $createdAt
    ): Collection {
        $allUserLine = $this->notificationUserLineRepository->getAllUserIdUserLine();
        $stores =
            DB::table('user')
                ->join('store', 'user.id', '=', 'store.user_id')
                ->select(DB::raw('store.id, store.store_name, store.phone_number, store.mail_address'))
                ->where(function ($query) use ($areaId, $industryId) {
                    if ($areaId > 0) {
                        $query->where('store.area_cd', '=', intval($areaId));
                    }
                    if ($industryId > 0) {
                        $query->where('store.business_type_id', '=', intval($industryId));
                    }
                })
                ->whereNull("store.mail_address")
                ->whereNotNull('store.phone_number')
                ->whereRaw("LENGTH(TRIM(store.phone_number)) > 0")
                ->where('user.created_at', '<=', $createdAt)
                ->where('role', '=', 3)
                ->whereRaw("user.id = store.user_id")
                ->whereNotIn('user.id', $allUserLine)
                ->distinct()
                ->get();

        return $stores->map(function ($store) {
            $store->phoneNumberDecrypted = $store->phone_number;

            try{
                $store->phoneNumberDecrypted = Crypt::decryptString($store->phone_number);
            }catch(Exception $ex){
            }

            return $store;
        });
    }

    /**
     * @param string $userId
     *
     * @return Seeker|null
     */
    public function getSeekerWithUserId(string $userId): ?Seeker
    {
        return Seeker::whereUserId($userId)->first();
    }

    /**
     * @param int $areaId
     * @param int $industryId
     * @param string $createdAt
     *
     * @return Collection
     */
    public function getSeekerHasLineWithAreaIDIndustryIDCreatedAt(
        int $areaId,
        int $industryId,
        string $createdAt
    ): Collection {
        $allUserLine = $this->notificationUserLineRepository->getAllUserIdUserLine();

        $nameTableSeekerLocation = $areaId > 0 ? ', seeker_expect_location sel' : '';
        $nameTableSeekerIndustry = $industryId > 0 ? ', seeker_expect_industry sei' : '';

        $seekers = DB::table(DB::raw("user {$nameTableSeekerLocation} {$nameTableSeekerIndustry}"))
            ->select(DB::raw('user.id, user.email, user.phone_number_landline'))
            ->where(function ($query) use ($areaId, $industryId) {
                if ($areaId > 0) {
                    $query->where('sel.area_id', '=', $areaId);
                    $query->whereRaw("user.id = sel.user_id");
                }

                if ($industryId > 0) {
                    $query->where('sei.industry_id', '=', $industryId);
                    $query->whereRaw("user.id = sei.user_id");
                }
            })
            ->where('user.role', '=', 2)
            ->whereIn('user.id', $allUserLine)
            ->where('user.created_at', '<=', $createdAt)
            ->distinct()
            ->get();

        return $seekers->map(function ($seeker) {
            $seeker->lineId = $this->notificationUserLineRepository->getLineIdWithUserId($seeker->id);

            $dataSeeker = $this->getSeekerWithUserId($seeker->id);

            if (isset($dataSeeker)) {
                $seeker->nickname = $dataSeeker->nickname;

                $seeker->realname = $dataSeeker->realname;

                try{
                    $seeker->realname = $dataSeeker !== null ? Crypt::decryptString($dataSeeker->realname) : null;
                }catch(Exception $ex){
                }
            } else {
                $seeker->nickname = "";
            }

            return $seeker;
        });
    }

    /**
     * @param int $areaId
     * @param int $industryId
     * @param string $createdAt
     *
     * @return mixed
     */


    /**
     * @param int $areaId
     * @param int $industryId
     * @param string $createdAt
     *
     * @return mixed
     */
    public function getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt(
        int $areaId,
        int $industryId,
        string $createdAt
    ) {
        $allUserLine = $this->notificationUserLineRepository->getAllUserIdUserLine();

        $nameTableSeekerLocation = ($areaId > 0 ? ', seeker_expect_location sel' : '');
        $nameTableSeekerIndustry = ($industryId > 0 ? ', seeker_expect_industry sei' : '');
        $seekers = DB::table(DB::raw("user {$nameTableSeekerLocation} {$nameTableSeekerIndustry}"))
            ->select(DB::raw('user.id, user.email, user.phone_number_landline'))
            ->where(function ($query) use ($areaId, $industryId) {
                if ($areaId > 0) {
                    $query->where('sel.area_id', '=', $areaId);
                    $query->whereRaw("user.id = sel.user_id");
                }
                if ($industryId > 0) {
                    $query->where('sei.industry_id', '=', $industryId);
                    $query->whereRaw("user.id = sei.user_id");
                }
            })
            ->whereNotNull('user.email')
            ->whereRaw("LENGTH(TRIM(user.email)) > 0")
            ->where('user.role', '=', 2)
            ->where('user.created_at', '<=', $createdAt)
            ->whereNotIn('user.id', $allUserLine)
            ->distinct()
            ->get();

        return $seekers->map(function ($seeker) {
            $dataSeeker = $this->getSeekerWithUserId($seeker->id);

            if (isset($dataSeeker)) {
                $seeker->nickname = $dataSeeker->nickname;
                try{
                    $seeker->realname = $dataSeeker->realname;
                    $seeker->realname = $dataSeeker !== null ? Crypt::decryptString($dataSeeker->realname) : null;
                }catch(Exception $ex){
                }
            } else {
                $seeker->nickname = "";
            }

            $seeker->emailDecrypted = $seeker->email;
            try {
                $seeker->emailDecrypted = Crypt::decryptString($seeker->email);
            }catch(Exception $ex){
            }

            return $seeker;
        });
    }

    /**
     * @param int $areaId
     * @param $industryId
     * @param string $createdAt
     *
     * @return mixed
     */
    public function getSeekerOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt(
        int $areaId,
            $industryId,
        string $createdAt
    ) {
        $allUserLine = $this->notificationUserLineRepository->getAllUserIdUserLine();

        $nameTableSeekerLocation = ($areaId > 0 ? ', seeker_expect_location sel' : '');
        $nameTableSeekerIndustry = ($industryId > 0 ? ', seeker_expect_industry sei' : '');
        $seekers = DB::table(DB::raw("user {$nameTableSeekerLocation} {$nameTableSeekerIndustry}"))
            ->select(DB::raw('user.id, user.email, user.phone_number_landline'))
            ->where(function ($query) use ($areaId, $industryId) {
                if ($areaId > 0) {
                    $query->where('sel.area_id', '=', $areaId);
                    $query->whereRaw("user.id = sel.user_id");
                }
                if ($industryId > 0) {
                    $query->where('sei.industry_id', '=', $industryId);
                    $query->whereRaw("user.id = sei.user_id");
                }
            })
            ->whereNull('user.email')
            ->whereNotNull("user.phone_number_landline")
            ->whereRaw("LENGTH(TRIM(user.phone_number_landline)) > 0")
            ->where('user.role', '=', 2)
            ->where('user.created_at', '<=', $createdAt)
            ->whereNotIn('user.id', $allUserLine)
            ->distinct()
            ->get();

        return $seekers->map(function ($seeker) {
            $dataSeeker = $this->getSeekerWithUserId($seeker->id);

            if (isset($dataSeeker)) {
                $seeker->nickname = $dataSeeker->nickname;
                $seeker->realname = $dataSeeker->realname;

                try{
                    $seeker->realname = $dataSeeker !== null ? Crypt::decryptString($dataSeeker->realname) : null;
                }catch(Exception $ex){
                }
            } else {
                $seeker->nickname = "";
            }

            $seeker->phoneNumberDecrypted = $seeker->phone_number_landline;

            try{
                $seeker->phoneNumberDecrypted = Crypt::decryptString($seeker->phone_number_landline);
            }catch(Exception $ex){
            }

            return $seeker;
        });
    }

    /**
     * @param int $areaId
     * @param int $industryId
     * @param string $createdAt
     *
     * @return Collection
     */
    public function getUserHasLine() : Collection
    {
        $allUserLine = $this->notificationUserLineRepository->getAllUserIdUserLine();

        $lineUsers = DB::table("user")
            ->select('user.id')
            ->where('user.role', '=', 1)
            ->whereIn('user.id', $allUserLine)
            ->distinct()
            ->get();

        return $lineUsers->map(function ($lineUser) {
            $lineUser->lineId = $this->notificationUserLineRepository->getLineIdWithUserId($lineUser->id);
            unset($lineUser->id);
            return $lineUser;
        });
    }

    /**
     * @return mixed
     */
    public function getUserNotLineHasMail() : mixed
    {
        $allUserLine = $this->notificationUserLineRepository->getAllUserIdUserLine();

        $mailUsers = DB::table("user")
            ->select('user.email')
            ->whereNotNull('user.email')
            ->whereRaw("LENGTH(TRIM(user.email)) > 0")
            ->where('user.role', '=', 1)
            ->whereNotIn('user.id', $allUserLine)
            ->distinct()
            ->get();

        foreach ($mailUsers as $mailUser)
        {
            $mailUser->email = $mailUser->email;

            try{
                $mailUser->email = Crypt::decryptString($mailUser->email);
            }catch(Exception $ex){
            }
        }

        return $mailUsers;
    }

    /**
     * @return mixed
     */
    public function getUserOnlyHasPhoneNumber() {
        $allUserLine = $this->notificationUserLineRepository->getAllUserIdUserLine();

        $smsUsers = DB::table("user")
            ->select(DB::raw('user.phone_number_landline'))
            ->whereNull('user.email')
            ->whereNotNull("user.phone_number_landline")
            ->whereRaw("LENGTH(TRIM(user.phone_number_landline)) > 0")
            ->where('user.role', '=', 1)
            ->whereNotIn('user.id', $allUserLine)
            ->distinct()
            ->get();

        return $smsUsers->map(function ($smsUser) {
            $smsUser->phone_number_landline = $smsUser->phone_number_landline;

            try{
                $smsUser->phone_number_landline = Crypt::decryptString($smsUser->phone_number_landline);
            }catch(Exception $ex){
            }

            return $smsUser;
        });
    }


    /**
     * @param string $userId
     *
     * @return Store|null
     */
    public function getStoreById(string $userId): ?Store
    {
        return Store::whereUserId($userId)->first();
    }



    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function loginAdmin(): Application|Factory|View|RedirectResponse
    {
        $adminData = Session::get('data_admin');
        if ($adminData) {
            return Redirect::to('/admin/register-line-list');
        } else {
            return view('admin.notification.login-admin');
        }

        return view('admin.notification.login-admin');
    }

    /**
     * @param array $data
     * @return string[]|true[]
     */
    public function handleSubmitLogin(array $data): array
    {
        $dataAdmin = Admin::where([
            'username' => $data['username'],
            'password' => $data['password']
        ])->get()->first();

        if (null !== $dataAdmin) {

            session()->put('data_admin', $dataAdmin);

            return ['logged_in' => true];
        } else {
            return ['mess' => "Wrong username or password"];
        }
    }

    /**
     * @return RedirectResponse
     */
    public function reqLogout(): RedirectResponse
    {
        Session::forget('data_admin');
        return Redirect::to('/admin');
    }

}
