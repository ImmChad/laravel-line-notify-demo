<?php

namespace App\Services;

use App\Repository\NotificationRepository;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    const PARAM_REGION_NAME = "{region_nm}";
    const PARAM_REGION_KEY = "{region_key}";
    const PARAM_AREA_KEY = "{area_key}";
    const PARAM_SHOP_NAME = "{shop_nm}";
    const PARAM_SHOP_PASS = "{shop_pass}";
    const PARAM_SHOP_ID = "{shop_id}";
    const PARAM_TIME_START_PUBLISH = "{s_date}";
    const PARAM_TIME_FINISH_PUBLISH = "{e_date}";
    const PARAM_PERIOD_PUBLISH = "{period}";
    const PARAM_PLAN = "{plan}";
    const PARAM_USER_NAME = "{user_nm}";
    const PARAM_PREFECTURE_NAME = "{prefecture_nm}";
    const PARAM_BUSINESS_NAME = "{business_nm}";
    const PARAM_BR = "{br}";


    public function __construct(private NotificationRepository $notificationRepository)
    {

    }

    /**
     * @param string $contentNotification
     * @return string
     */
    public function loadParamNotificationStore(string $contentNotification, string $storeId, String $typeSend="notMail"): string
    {
        $dataStore = DB::table('store')->where("id", $storeId)->first();

        if (strpos($contentNotification, self::PARAM_REGION_NAME) >= 0) {
            $dataRegion = DB::table(DB::raw("store, static_region, static_pref, static_area"))
                ->select(DB::raw("static_region.region_name_jp"))
                ->whereRaw("store.area_cd = static_area.area_cd")
                ->whereRaw("static_area.pref_cd = static_pref.pref_cd")
                ->whereRaw("static_pref.region_cd = static_region.region_cd")
                ->distinct()
                ->where("store.id", $storeId)->first();
            $regionName = isset($dataRegion) ? $dataRegion->region_name_jp : "Your Region";
            $contentNotification = str_replace(self::PARAM_REGION_NAME, $regionName ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_REGION_KEY) >= 0) {
            $dataRegion = DB::table(DB::raw("store, static_region, static_pref, static_area"))
                ->select(DB::raw("static_region.region_name"))
                ->whereRaw("store.area_cd = static_area.area_cd")
                ->whereRaw("static_area.pref_cd = static_pref.pref_cd")
                ->whereRaw("static_pref.region_cd = static_region.region_cd")
                ->distinct()
                ->where("store.id", $storeId)->first();
            $regionName = isset($dataRegion) ? $dataRegion->region_name : "";
            $contentNotification = str_replace(self::PARAM_REGION_KEY, $regionName ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_AREA_KEY) >= 0) {
            $dataArea = DB::table(DB::raw("store, static_area"))
                ->select(DB::raw("static_area.area_name"))
                ->whereRaw("store.area_cd = static_area.area_cd")
                ->distinct()
                ->where("store.id", $storeId)->first();
            $areaName = isset($dataArea) ? $dataArea->area_name : "";
            $contentNotification = str_replace(self::PARAM_AREA_KEY, $areaName ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_SHOP_NAME) >= 0) {
            $contentNotification = str_replace(self::PARAM_SHOP_NAME, $dataStore->store_name ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_SHOP_PASS) >= 0) {
            $passwordUser = DB::table("user")
                ->select(DB::raw("user.password"))
                ->where("user.id", $dataStore->user_id)
                ->distinct()
                ->first()->password;
            $contentNotification = str_replace(self::PARAM_SHOP_PASS, $passwordUser, $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_SHOP_ID) >= 0) {
            $contentNotification = str_replace(self::PARAM_SHOP_ID, $dataStore->id ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_TIME_START_PUBLISH) >= 0) {
            $contentNotification = str_replace(self::PARAM_TIME_START_PUBLISH, $dataStore->setting_password_at ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_TIME_FINISH_PUBLISH) >= 0) {
            $contentNotification = str_replace(self::PARAM_TIME_FINISH_PUBLISH, $dataStore->updated_at ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_PERIOD_PUBLISH) >= 0) {
            $period = null;
            if (isset($dataStore->setting_password_at) && $dataStore->commencement_business_date) {
                $start = new \DateTime($dataStore->setting_password_at);
                $end = new \DateTime($dataStore->updated_at);
                $period = $start->diff($end);
            }
            $contentNotification = str_replace(self::PARAM_PERIOD_PUBLISH, isset($period) ? "{$period->d} days {$period->h} hours" : "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_PLAN) >= 0) {
            $contentNotification = str_replace(self::PARAM_PLAN, "Free", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_BR) >= 0 )
        {
            if($typeSend == "notMail")
            {
                $contentNotification = str_replace(self::PARAM_BR, "\r\n", $contentNotification);
            }
            else
            {
                $contentNotification = str_replace(self::PARAM_BR, "<br>", $contentNotification);
            }
        }

        return $contentNotification;
    }

    public function loadParamNotificationUser(string $contentNotification, string $userId, String $typeSend="notMail"): string
    {
        $dataUser = DB::table('user')->where("id", $userId)->first();

        //{}
        if (strpos($contentNotification, self::PARAM_USER_NAME) >= 0) {
            $dataUser->detailSeeker = $this->notificationRepository->getSeekerWithUserId($userId);
            if (isset($dataUser->detailSeeker)) {
                $contentNotification = str_replace(self::PARAM_USER_NAME, $dataUser->detailSeeker->nickname, $contentNotification);
            } else {
                $contentNotification = str_replace(self::PARAM_USER_NAME, "Your name", $contentNotification);
            }
        }

        if (strpos($contentNotification, self::PARAM_REGION_NAME) >= 0) {
            $dataRegion = DB::table(DB::raw("seeker_expect_location, static_region, static_pref , static_area"))
                ->select(DB::raw("static_region.region_name_jp"))
                ->whereRaw("seeker_expect_location.area_id = static_area.area_cd")
                ->whereRaw("static_area.pref_cd = static_pref.id")
                ->whereRaw("static_pref.region_cd = static_region.region_cd")
                ->distinct()
                ->where("seeker_expect_location.user_id", $userId)->first();
            $regionName = isset($dataRegion) ? $dataRegion->region_name_jp : "";
            $contentNotification = str_replace(self::PARAM_REGION_NAME, $regionName ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_REGION_KEY) >= 0) {
            $dataRegion = DB::table(DB::raw("seeker_expect_location, static_region, static_pref , static_area"))
                ->select(DB::raw("static_region.region_name"))
                ->whereRaw("seeker_expect_location.area_id = static_area.area_cd")
                ->whereRaw("static_area.pref_cd = static_pref.id")
                ->whereRaw("static_pref.region_cd = static_region.region_cd")
                ->distinct()
                ->where("seeker_expect_location.user_id", $userId)->first();
            $regionName = isset($dataRegion) ? $dataRegion->region_name : "Your Region";
            $contentNotification = str_replace(self::PARAM_REGION_KEY, $regionName ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_PREFECTURE_NAME) >= 0) {
            $dataPref = DB::table(DB::raw("seeker_expect_location, static_pref , static_area"))
                ->select(DB::raw("static_pref.pref_name"))
                ->whereRaw("seeker_expect_location.area_id = static_area.area_cd")
                ->whereRaw("static_area.pref_cd = static_pref.id")
                ->distinct()
                ->where("seeker_expect_location.user_id", $userId)->first();

            $prefName = isset($dataPref)?$dataPref->pref_name:"No pref name";
            $contentNotification = str_replace(self::PARAM_PREFECTURE_NAME, $prefName??"", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_AREA_KEY) >= 0) {
            $dataArea = DB::table(DB::raw("seeker_expect_location, static_area"))
                ->select(DB::raw("static_area.area_name"))
                ->whereRaw("seeker_expect_location.area_id = static_area.area_cd")
                ->distinct()
                ->where("seeker_expect_location.user_id", $userId)->first();
            $areaName = isset($dataArea) ? $dataArea->area_name : "Your Area";
            $contentNotification = str_replace(self::PARAM_AREA_KEY, $areaName ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_BUSINESS_NAME) >= 0) {
            $dataIndustry = DB::table(DB::raw("seeker_expect_industry, static_industry"))
                ->select(DB::raw("static_industry.industry_name_jp"))
                ->whereRaw("seeker_expect_industry.industry_id = static_industry.id")
                ->distinct()
                ->where("seeker_expect_industry.user_id", $userId)->first();
            $industryName = isset($dataIndustry) ? $dataIndustry->industry_name_jp : "Your Industry";
            $contentNotification = str_replace(self::PARAM_BUSINESS_NAME, $industryName ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_SHOP_NAME) >= 0) {
            $dataStore = DB::table(DB::raw("store"))
                ->select(DB::raw("store.store_name"))
                ->where("store.user_id", $userId)
                ->distinct()->first();
            $storeName = isset($dataStore) ? $dataStore->store_name : 'Store Name';
            $contentNotification = str_replace(self::PARAM_SHOP_NAME, $storeName ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_SHOP_ID) >= 0) {
            $dataStore = DB::table(DB::raw("store"))
                ->select(DB::raw("store.id"))
                ->where("store.user_id", $userId)
                ->distinct()->first();
            $id = isset($dataStore) ? $dataStore->id : "";
            $contentNotification = str_replace(self::PARAM_SHOP_ID, $id ?? "", $contentNotification);
        }

        if (strpos($contentNotification, self::PARAM_BR) >= 0 )
        {
            if($typeSend == "notMail")
            {
                $contentNotification = str_replace(self::PARAM_BR, "\r\n", $contentNotification);
            }
            else
            {
                $contentNotification = str_replace(self::PARAM_BR, "<br>", $contentNotification);
            }
        }

        return $contentNotification;
    }
}
