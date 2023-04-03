<?php

namespace App\Handler;

use App\Events\NewNotificationFromAdminEvent;
use App\Models\Notification;
use App\Models\NotificationDraft;
use App\Models\NotificationRead;
use App\Repository\NotificationDraftRepository;
use App\Repository\NotificationParamStoreRepository;
use App\Repository\NotificationParamUserRepository;
use App\Repository\NotificationReadRepository;
use App\Repository\NotificationRepository;
use App\Repository\NotificationTemplateRepository;
use App\Repository\NotificationTypeRepository;
use App\Repository\NotificationUserLineRepository;
use App\Services\NotificationService;
use App\Services\NotificationUserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class NotificationHandler
{
    protected const NOTIFICATION_FROM_ADMIN = 2;


    /**
     * @param NotificationRepository $notificationRepository
     * @param NotificationReadRepository $notificationReadRepository
     * @param NotificationTemplateRepository $notificationTemplateRepository
     * @param NotificationTypeRepository $notificationTypeRepository
     * @param NotificationDraftRepository $notificationDraftRepository
     * @param NotificationParamStoreRepository $notificationParamStoreRepository
     * @param NotificationParamUserRepository $notificationParamUserRepository
     * @param NotificationUserLineRepository $notificationUserLineRepository
     * @param NotificationUserService $notificationUserService
     */
    public function __construct(
        private NotificationRepository           $notificationRepository,
        private NotificationDraftHandler         $notificationDraftHandler,
        private NotificationReadRepository       $notificationReadRepository,
        private NotificationTemplateRepository   $notificationTemplateRepository,
        private NotificationTypeRepository       $notificationTypeRepository,
        private NotificationDraftRepository      $notificationDraftRepository,
        private NotificationParamStoreRepository $notificationParamStoreRepository,
        private NotificationParamUserRepository  $notificationParamUserRepository,
        private NotificationUserLineRepository   $notificationUserLineRepository,
        private NotificationUserService          $notificationUserService,
        private NotificationService              $notificationService
    )
    {
    }

    /**
     * @param int $notificationId
     * @return View|Factory|RedirectResponse|Application
     */
    public function showContentUpdateNotificationToView(int $notificationId): View|Factory|RedirectResponse|Application
    {
        $getNotification = DB::table('notification')->where('id', $notificationId)->first();

//        dd($getNotification);

        if ($getNotification->is_sent != 1) {
            $notification_draft_id = $getNotification->notification_draft_id;
            $returnData = $this->notificationDraftRepository->getNotificationDraftWithID($getNotification->notification_draft_id);
            $dataNotification = $returnData;

            $dataTemplate = $this->notificationTemplateRepository->getTemplateByTemplateType(
                $dataNotification->notification_for
            );
            $dataRegion = DB::table('static_region')->get();
            $dataIndustry = DB::table('static_industry')->get();

            if ($dataNotification->notification_for == "user") {
                $listParam = $this->notificationParamUserRepository->getAll();
            } else {
                $listParam = $this->notificationParamStoreRepository->getAll();
            }

            if ($dataNotification->area_id != 0) {
                $regionId = $this->notificationUserService->getRegionIdByAreaId($dataNotification->area_id)->id;

                $dataArea = $this->notificationUserService->getAreaFromRegionId($regionId);

                return view(
                    'admin.notification.update-notification-view-3',
                    compact(
                        'dataNotification',
                        'dataTemplate',
                        'dataRegion',
                        'dataIndustry',
                        'listParam',
                        'regionId',
                        'dataArea',
                        'notificationId',
                        'notification_draft_id'
                    )
                );
            } else {
                return view(
                    'admin.notification.update-notification-view-3',
                    compact(
                        'dataNotification',
                        'dataTemplate',
                        'dataRegion',
                        'dataIndustry',
                        'listParam',
                        'notificationId',
                        'notification_draft_id'
                    )
                );
            }
        } else {
            return Redirect::to('/admin/notification-list');
        }
    }

    /**
     * @return array
     */
    public function getRegisterLineList(): array
    {
        $listUser = DB::table('user')->get();
        $data = [];

        foreach ($listUser as $subListUser) {
            $lineId = $this->notificationUserLineRepository->getLineIdWithUserId($subListUser->id);
            if (null !== $lineId) {
                $subListUser->line_id = $lineId;
                $data[] = $subListUser;
            }
        }


        foreach ($data as $subData) {

            if ($subData->role == 2) {
                $seeker = DB::table('seeker')->where(['user_id' => $subData->id])->first();

                $subData->typeRole = 2;
                $subData->name = $seeker->nickname ?? "No has name";

            } else if ($subData->role == 3) {

                $store = DB::table('store')->where(['user_id' => $subData->id])->first();

                $subData->typeRole = 3;
                $subData->name = $store->store_name ?? "No has name";

            } else if ($subData->role == 1) {
                $subData->typeRole = 1;
                $subData->name = "No has name";

            }
        }

        return $data;
    }

    /**
     * @param object $request
     *
     * @return Collection
     */
    public function searchNotification(object $request): Collection
    {
        $textSearch = $request['txt-search-notification'];
        $textSearch == null ? $textSearch = "" : $textSearch;
        $matchedNotifications = $this->notificationRepository->getNotificationBySearch($textSearch);

        foreach ($matchedNotifications as $key => $notification) {
            $typeNotification = $this->notificationTypeRepository->getDetail($notification->type);
            $matchedNotifications[$key]->name_type = $typeNotification->type;

            if ($matchedNotifications[$key]->type == 2) {
                $countPerson = $this->notificationUserService->getUserReadNotification(
                    $matchedNotifications[$key]->id
                );

                $countRead = 0;
                foreach ($countPerson as $eachPerson) {
                    $checkRead = $this->notificationReadRepository->getNotificationRead(
                        $eachPerson->id,
                        $notification->id
                    );

                    if (count($checkRead) > 0) {
                        $countRead += 1;
                    }
                }

                $matchedNotifications[$key]->read_user = $countRead;
                $matchedNotifications[$key]->total_user = count($countPerson);
            } else if ($matchedNotifications[$key]->type == 1) {
                $totalUser = DB::table('user')
                        ->where('role', 1)
                        ->where('created_at', '<=', $matchedNotifications[$key]->created_at)
                        ->get();

                $countRead = 0;
                foreach ($totalUser as $eachUser) {
                    $checkRead = $this->notificationReadRepository->getNotificationRead(
                        $eachUser->id,
                        $notification->id
                    );

                    if (count($checkRead) > 0) {
                        $countRead += 1;
                    }
                }


                $matchedNotifications[$key]->read_user = $countRead;


                $matchedNotifications[$key]->total_user = count($totalUser);

            }

            if (isset($request->templateType) && $request->templateType != 0) {

                if (isset($matchedNotifications[$key]->notification_draft_id)) {

                    $dataDraft = $this->notificationDraftRepository->getNotificationDraftWithID(
                        $matchedNotifications[$key]->notification_draft_id
                    );

                    $matchedNotifications[$key]->notification_for = $dataDraft->notification_for;

                    if (!(strtolower($request->templateType) == strtolower(
                            $matchedNotifications[$key]->notification_for
                        ))) {
                        unset($matchedNotifications[$key]);
                    }

                } else {
                    unset($matchedNotifications[$key]);
                }
            }
        }

        return $matchedNotifications;
    }

    /**
     * @param int $notificationType
     * @param string|null $notificationSender
     * @param string|null $notificationTemplate
     * @return View|Factory|RedirectResponse|Application
     */
    public function showSendNotificationView(
        int    $notificationType,
        string $notificationSender = null,
        string $notificationTemplate = null
    ): View|Factory|RedirectResponse|Application
    {
        $checkNotificationDraft = $this->notificationDraftHandler->getNotificationDraftForSummaryView();

        if (null !== $checkNotificationDraft) {
            $dataDraft = $this->notificationDraftHandler->getNotificationDraftForSummaryView();

            return view('admin.notification.draft-notification-view', compact('dataDraft'));
        } else {
            if ($notificationType == 2) {
                if (isset($_GET['messToast'])) {
                    $messToast = $_GET['messToast'];
                    return view('admin.notification.send-notification-view-2', compact('messToast'));
                } else {
                    return view('admin.notification.send-notification-view-2');
                }
            } else {
                if ($notificationType == 3) {
                    if (isset($_GET['messToast'])) {
                        $messToast = $_GET['messToast'];
                        return view('admin.notification.send-notification-view-3', compact('messToast'));
                    } else {
                        if ($notificationSender != null) {
                            $dataTemplate = $this->notificationTemplateRepository->getTemplateByTemplateType(
                                $notificationSender
                            );
                            $dataRegion = DB::table('static_region')->get();
                            $dataIndustry = DB::table('static_industry')->get();

                            if ($notificationSender == "user") {
                                $listParam = $this->notificationParamUserRepository->getAll();
                            } else {
                                $listParam = $this->notificationParamStoreRepository->getAll();
                            }

                            if ($notificationTemplate != null) {
                                $detailTemplate = $this->notificationTemplateRepository->getDetail($notificationTemplate);

                                return view(
                                    'admin.notification.send-notification-view-3',
                                    compact(
                                        'notificationSender',
                                        'dataTemplate',
                                        'detailTemplate',
                                        'dataRegion',
                                        'dataIndustry',
                                        'listParam'
                                    )
                                );
                            } else {
                                return view(
                                    'admin.notification.send-notification-view-3',
                                    compact(
                                        'notificationSender',
                                        'dataTemplate',
                                        'dataRegion',
                                        'dataIndustry',
                                        'listParam'
                                    )
                                );
                            }
                        } else {
                            return view('admin.notification.send-notification-view-3');
                        }
                    }
                } else {
                    return Redirect::to('/admin/notification-list');
                }
            }
        }
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function sendMessForListUser(Request $request): int
    {
        $dataNotificationDraft = $this->notificationDraftRepository->getNotificationDraftWithID(
            $request->notification_draft_id
        );
        $newNotificationId = $this->notificationRepository->insertDataNotification([
            'type' => NotificationHandler::NOTIFICATION_FROM_ADMIN,
            'announce_title' => $request->notificationTitle,
            'announce_content' => $request->notificationContent,
            'is_sent' => !isset($dataNotificationDraft->scheduled_at),
            'is_scheduled' => isset($dataNotificationDraft->scheduled_at),
            'created_at' => date('Y/m/d H:i:s'),
            'scheduled_at' => $dataNotificationDraft->scheduled_at,
            'notification_draft_id' => $request->notification_draft_id
        ]);
        $resultRemove = $this->notificationDraftRepository->removeNotificationDraft($request);

        if ($resultRemove) {
            event((new NewNotificationFromAdminEvent($newNotificationId,
                $this->notificationRepository,
                $this->notificationDraftRepository,
                $this->notificationService,
                $this->notificationUserService
            )));
        }
        return $newNotificationId;
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    function sendUpdateForListUser(Request $request): int
    {

        $this->updateNotificationDraft($request);

        return $this->notificationRepository->updateNotificationForListUser($request);
    }

    /**
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     */
    function detailNotification(int $id): Application|Factory|View|RedirectResponse
    {
        $dataAdmin = Session::get('data_admin');

        if ($dataAdmin) {
            $notification = $this->notificationRepository->getDetail($id);
            $typeNotification = $this->notificationTypeRepository->getDetail($notification->type);
            $notification->name_type = $typeNotification->type;

            return view("admin.notification.view-announce-admin-detail", compact('notification'));

        } else {
            return Redirect::to('/');
        }
    }

    /**
     * @param int $notificationId
     * @return RedirectResponse
     */
    function deleteNotification(int $notificationId): RedirectResponse
    {
        $this->notificationRepository->deleteNotification($notificationId);
        return Redirect::to('/admin/notification-list');
    }

    /**
     * @param int $regionId
     * @return Collection|array
     */
    function getAreaFromRegionId(int $regionId): Collection|array
    {
        $regionCd = DB::table('static_region')->where('id', $regionId)->first();
        $listPrefId = $this->notificationUserService->getPrefFromRegionCd($regionCd->region_cd);

        $result = [];
        foreach ($listPrefId as $subListPrefId) {
            $result = array_merge($result, $this->notificationUserService->getAreaFromRegionId($subListPrefId->pref_cd)->toArray());
        }

        return $result;
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    public function updateNotificationDraft(Request $request): int
    {
        $totalUserSms = 0;
        $totalUserLine = 0;
        $totalUserMail = 0;
        $now = date('Y/m/d H:i:s');

        if ($request->announceFor == "user") {
            $totalUserSms = count(
                $this->notificationUserService->getSeekerOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt(
                    $request->areaId,
                    $request->industryId,
                    $now
                )
            );
            $totalUserMail = count(
                $this->notificationUserService->getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt(
                    $request->areaId,
                    $request->industryId,
                    $now
                )
            );
            $totalUserLine = count(
                $this->notificationUserService->getSeekerHasLineWithAreaIDIndustryIDCreatedAt($request->areaId, $request->industryId, $now)
            );
        } else if ($request->announceFor == "store") {
            $totalUserSms = count(
                $this->notificationUserService->getStoreOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt(
                    $request->areaId,
                    $request->industryId,
                    $now
                )
            );
            $totalUserMail = count(
                $this->notificationUserService->getStoreNotLineHasMailWithAreaIDIndustryIDCreatedAt(
                    $request->areaId,
                    $request->industryId,
                    $now
                )
            );
            $totalUserLine = count(
                $this->notificationUserService->getStoreHasLineWithAreaIDIndustryIDCreatedAt($request->areaId, $request->industryId, $now)
            );
        }


        return DB::table('notification_draft')
            ->where('id', $request->getDraftId)
            ->update([
                'notification_for' => $request->announceFor,
                'notification_title' => $request->title,
                'notification_content' => $request->message,
                'area_id' => $request->areaId,
                'industry_id' => $request->industryId,
                'sms_user' => $totalUserSms,
                'line_user' => $totalUserLine,
                'mail_user' => $totalUserMail,
                'updated_at' => $now,
            ]);
    }


}
