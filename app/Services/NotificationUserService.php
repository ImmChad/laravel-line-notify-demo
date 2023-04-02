<?php

namespace App\Services;

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

class NotificationUserService
{
    /**
     * @param NotificationRepository $notificationRepository
     * @param NotificationUserLineRepository $notificationUserLineRepository
     * @param NotificationDraftRepository $notificationDraftRepository
     * @param NotificationUserService $notificationUserService
     */
    public function __construct(
        private NotificationRepository $notificationRepository,
        private NotificationUserLineRepository $notificationUserLineRepository,
        private NotificationDraftRepository $notificationDraftRepository,
        private NotificationUserService $notificationUserService
    )
    {
    }

    /**
     * @param int $id
     *
     * @return Collection|array
     */

    public function getUsersCreatedBeforeNotificationCurrent(int $id): Collection|array
    {
        $dataNotification = DB::table("notification")->where("id", $id)->first();
        $dataNotificationDraft = $this->notificationDraftRepository
            ->getNotificationDraftWithID($dataNotification->notification_draft_id);

        if (isset($dataNotificationDraft) && $dataNotification->type != 1) {
            if ($dataNotificationDraft->notification_for == "user") {
                return self::getAllUserIdSeekerWithAreaIDIndustryIDCreatedAt(
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
    public function getAreaFromRegionId(int $prefId): Collection
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
    public function getAllUserIdSeekerWithAreaIDIndustryIDCreatedAt(int $areaId, int $industryId, string $createdAt): Collection
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
            $store->emailDecrypted = Crypt::decryptString($store->mail_address);

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
            $store->phoneNumberDecrypted = Crypt::decryptString($store->phone_number);
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
        return DB::table('seeker')->where(['user_id' => $userId])->first();
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

            $dataSeeker = self::getSeekerWithUserId($seeker->id);
            if (isset($dataSeeker)) {
                $seeker->nickname = $dataSeeker->nickname;
                $seeker->realname = $dataSeeker !== null ? Crypt::decryptString($dataSeeker->realname) : null;
            } else {
                $seeker->nickname = "";
            }

            return $seeker;
        });
    }

    /**
     * @param int $areaId
     * @param int $industryId
     * @param string $created_at
     *
     * @return mixed
     */
    public function getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt(
        int $areaId,
        int $industryId,
        string $created_at
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
            ->where('user.created_at', '<=', $created_at)
            ->whereNotIn('user.id', $allUserLine)
            ->distinct()
            ->get();
        return $seekers->map(function ($seeker) {
            $dataSeeker = self::getSeekerWithUserId($seeker->id);
            if (isset($dataSeeker)) {
                $seeker->nickname = $dataSeeker->nickname;
                $seeker->realname = $dataSeeker !== null ? Crypt::decryptString($dataSeeker->realname) : null;
            } else {
                $seeker->nickname = "";
            }
            $seeker->emailDecrypted = Crypt::decryptString($seeker->email);

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
            $dataSeeker = self::getSeekerWithUserId($seeker->id);
            if (isset($dataSeeker)) {
                $seeker->nickname = $dataSeeker->nickname;
                $seeker->realname = $dataSeeker !== null ? Crypt::decryptString($dataSeeker->realname) : null;
            } else {
                $seeker->nickname = "";
            }
            $seeker->phoneNumberDecrypted = Crypt::decryptString($seeker->phone_number_landline);
            return $seeker;
        });
    }

    /**
     * @param string $userId
     *
     * @return Store|null
     */
    public function getFirstStoreWithUserID(string $userId): ?Store
    {
        return DB::table('store')->where("user_id", $userId)->first();
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
    }

    /**
     * @param array $request
     * @return string[]|true[]
     */
    public function handleSubmitLogin(array $request): array
    {
        $dataAdmin = $this->notificationUserService->handleSubmitLogin($request);

        if (count($dataAdmin) == 1) {
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
