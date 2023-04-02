<?php

namespace App\Handler;

use App\Models\NotificationTemplate;
use App\Repository\NotificationDraftRepository;
use App\Repository\NotificationParamStoreRepository;
use App\Repository\NotificationParamUserRepository;
use App\Repository\NotificationReadRepository;
use App\Repository\NotificationRepository;
use App\Repository\NotificationTemplateRepository;
use App\Repository\NotificationTypeRepository;
use App\Repository\NotificationUserLineRepository;
use App\Services\NotificationUserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class NotificationDraftHandler
{
    /**
     * @param NotificationRepository $notificationRepository
     * @param NotificationReadRepository $notificationReadRepository
     * @param NotificationUserLineRepository $notificationUserLineRepository
     * @param NotificationTemplateRepository $notificationTemplateRepository
     * @param NotificationTypeRepository $notificationTypeRepository
     * @param NotificationDraftRepository $notificationDraftRepository
     * @param NotificationParamStoreRepository $notificationParamStoreRepository
     * @param NotificationParamUserRepository $notificationParamUserRepository
     * @param NotificationUserService $notificationUserService
     */
    public function __construct(
        private NotificationRepository $notificationRepository,
        private NotificationReadRepository $notificationReadRepository,
        private NotificationUserLineRepository $notificationUserLineRepository,
        private NotificationTemplateRepository $notificationTemplateRepository,
        private NotificationTypeRepository $notificationTypeRepository,
        private NotificationDraftRepository $notificationDraftRepository,
        private NotificationParamStoreRepository $notificationParamStoreRepository,
        private NotificationParamUserRepository $notificationParamUserRepository,
        private NotificationUserService $notificationUserService
    ) {
    }

    /**
     * @param Request $request
     * @return int
     */
    public function cancelNotificationDraft(Request $request): int
    {
        return $this->notificationDraftRepository->cancelNotificationDraft($request->notification_draft_id);
    }

    /**
     * @param string $notificationDraftId
     * @param string|null $notificationSender
     * @param string|null $notificationTemplate
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
     */
    public function renderUpdateNotificationDraft(
        string $notificationDraftId,
        string $notificationSender = null,
        string $notificationTemplate = null
    ): Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse {
        $dataDraft = $this->notificationDraftRepository->getNotificationDraftWithID($notificationDraftId);

        $detailTemplate = new NotificationTemplate();
        $detailTemplate->id = null;
        $detailTemplate->template_title = $dataDraft->notification_title;
        $detailTemplate->template_content = $dataDraft->notification_content;

        if ("user" === $dataDraft->notification_for) {
            $listParam = $this->notificationParamUserRepository->getAll();
        } else {
            $listParam = $this->notificationParamStoreRepository->getAll();
        }

        if (null !== $dataDraft) {
            if (null !== $notificationSender) {
                $dataTemplate = $this->notificationTemplateRepository->getTemplateByTemplateType($notificationSender);
                $dataRegion = DB::table('static_region')->get();
                $dataIndustry = DB::table('static_industry')->get();

                if (null !== $notificationTemplate) {
                    $detailTemplate = $this->notificationTemplateRepository->getDetail($notificationTemplate);
                    return view(
                        'admin.notification.update-notification-draft',
                        compact(
                            'dataDraft',
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
                        'admin.notification.update-notification-draft',
                        compact(
                            'dataDraft',
                            'notificationSender',
                            'dataTemplate',
                            'detailTemplate',
                            'dataRegion',
                            'dataIndustry',
                            'listParam'
                        )
                    );
                }
            } else {
                return view(
                    'admin.notification.update-notification-draft',
                    compact('dataDraft', 'notificationSender', 'detailTemplate', 'listParam')
                );
            }
        } else {
            return Redirect::to('/admin/notification-list');
        }
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    public function updateNotificationDraft(Request $request): int
    {
        $request->validate([
            'title' => 'required|max:255',
            'message' => 'required',
        ]);

        if ($request->announceFor == "user") {
            if (intval($request->announceTypeFor) == 1) {
                $listSeeker = $this->notificationUserService->getListUserAllRole2();
            } else {
                if (intval($request->areaId) == 0 && intval($request->industryId) == 0) {
                    $listSeeker = $this->notificationUserService->getListUserAllRole2();
                } else {
                    $listSeeker = $this->notificationUserService->getListUserRole2ById($request);
                }
            }

            $totalUserLine = 0;
            $totalUserMail = 0;
            $totalUserSms = 0;
            foreach ($listSeeker as $subListSeeker) {
                if (count($this->notificationUserLineRepository->getListUserLine($subListSeeker->id)) > 0) {
                    $totalUserLine += 1;
                } else {
                    if ($subListSeeker->email != null) {
                        $totalUserMail += 1;
                    } else {
                        if ($subListSeeker->phone_number_landline != null) {
                            $totalUserSms += 1;
                        }
                    }
                }
            }
        } else {
            if ($request->announceTypeFor == 1) {
                $listStore = $this->notificationUserService->getListUserAllRole3();
            } else {
                if (intval($request->areaId) == 0 && intval($request->industryId) == 0) {
                    $listStore = $this->notificationUserService->getListUserAllRole3();
                } else {
                    $listStore = $this->notificationUserService->getListUserRole3ById($request);
                }
            }
            $totalUserLine = 0;
            $totalUserMail = 0;
            $totalUserSms = 0;
            foreach ($listStore as $subListStore) {
                if (count($this->notificationUserLineRepository->getListUserLine($subListStore->id)) > 0) {
                    $totalUserLine += 1;
                } else {
                    if ($subListStore->mail_address != null) {
                        $totalUserMail += 1;
                    } else {
                        if ($subListStore->phone_number != null) {
                            $totalUserSms += 1;
                        }
                    }
                }
            }
        }
        return $this->notificationDraftRepository->updateNotificationDraft($request);
    }

    /**
     * @param object $request
     * @return int
     */
    public function saveNotificationDraft(object $request): int
    {
        if ($request->announceFor == "user") {
            if (intval($request->announceTypeFor) == 1) {
                $listSeeker = $this->notificationUserService->getListUserAllRole2();
            } else {
                if (intval($request->areaId) == 0 && intval($request->industryId) == 0) {
                    $listSeeker = $this->notificationUserService->getListUserAllRole2();
                } else {
                    $listSeeker = $this->notificationUserService->getListUserRole2ById($request);
                }
            }

            $totalUserLine = 0;
            $totalUserMail = 0;
            $totalUserSms = 0;

            foreach ($listSeeker as $subListSeeker) {
                if (count($this->notificationUserLineRepository->getListUserLine($subListSeeker->id)) > 0) {
                    $totalUserLine += 1;
                } else {
                    if ($subListSeeker->email != null) {
                        $totalUserMail += 1;
                    } else {
                        if ($subListSeeker->phone_number_landline != null) {
                            $totalUserSms += 1;
                        }
                    }
                }
            }
        } else {
            if ($request->announceTypeFor == 1) {
                $listStore = $this->notificationUserService->getListUserAllRole3();
            } else {
                if (intval($request->areaId) == 0 && intval($request->industryId) == 0) {
                    $listStore = $this->notificationUserService->getListUserAllRole3();
                } else {
                    $listStore = $this->notificationUserService->getListUserRole3ById($request);
                }
            }
            $totalUserLine = 0;
            $totalUserMail = 0;
            $totalUserSms = 0;
            foreach ($listStore as $subListStore) {
                if (count($this->notificationUserLineRepository->getListUserLine($subListStore->id)) > 0) {
                    $totalUserLine += 1;
                } else {
                    if ($subListStore->mail_address != null) {
                        $totalUserMail += 1;
                    } else {
                        if ($subListStore->phone_number != null) {
                            $totalUserSms += 1;
                        }
                    }
                }
            }
        }

        return $this->notificationDraftRepository->saveNotificationDraft(
            $request,
            $totalUserLine,
            $totalUserMail,
            $totalUserSms
        );
    }
}
