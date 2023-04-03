<?php

namespace App\Handler;

use App\Models\NotificationDraft;
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
use Illuminate\Support\Str;

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
        private NotificationRepository           $notificationRepository,
        private NotificationReadRepository       $notificationReadRepository,
        private NotificationUserLineRepository   $notificationUserLineRepository,
        private NotificationTemplateRepository   $notificationTemplateRepository,
        private NotificationTypeRepository       $notificationTypeRepository,
        private NotificationDraftRepository      $notificationDraftRepository,
        private NotificationParamStoreRepository $notificationParamStoreRepository,
        private NotificationParamUserRepository  $notificationParamUserRepository,
        private NotificationUserService          $notificationUserService
    )
    {
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
     * @return Application|Factory|View|RedirectResponse
     */
    public function renderUpdateNotificationDraft(
        string $notificationDraftId,
        string $notificationSender = null,
        string $notificationTemplate = null
    ): Application|Factory|View|RedirectResponse
    {
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

    /**
     * @param object $request
     * @return int
     */


    /**
     * @return NotificationDraft|null
     */
    public function getNotificationDraftForSummaryView(): ?NotificationDraft
    {


        $dataDraft = NotificationDraft::where(['is_processed' => 0])->first();

        if (isset($dataDraft)) {
            if ($dataDraft->notification_for == "user") {
                $dataDraft->lineUsers = $this->notificationUserService->getSeekerHasLineWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
                $dataDraft->emailUsers = $this->notificationUserService->getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
                $dataDraft->smsUsers = $this->notificationUserService->getSeekerOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
            } else if ($dataDraft->notification_for == "store") {
                $dataDraft->lineUsers = $this->notificationUserService->getStoreHasLineWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
                $dataDraft->emailUsers = $this->notificationUserService->getStoreNotLineHasMailWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
                $dataDraft->smsUsers = $this->notificationUserService->getStoreOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt($dataDraft->area_id, $dataDraft->industry_id, $dataDraft->created_at);
            }
        }

        return $dataDraft;
    }


    /**
     * From Repository
     * @param Request $request
     *
     * @return int
     */
    public function saveNotificationDraft(Request $request): int
    {
        $isScheduled = $request->delayTime > 0;
        $scheduledAt = $isScheduled ? now()->addSeconds(intval($request->delayTime)) : null;
        $now = date('Y/m/d H:i:s');
        $totalUserSms = 0;
        $totalUserLine = 0;
        $totalUserMail = 0;

        if ("user" === $request->announceFor) {


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
                $this->notificationUserService->getSeekerHasLineWithAreaIDIndustryIDCreatedAt(
                    $request->areaId,
                    $request->industryId,
                    $now
                )
            );

        } else if ("store" === $request->announceFor) {
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
                $this->notificationUserService->getStoreHasLineWithAreaIDIndustryIDCreatedAt(
                    $request->areaId,
                    $request->industryId,
                    $now
                )
            );
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
            'mail_user' => $totalUserMail,
            'created_at' => $now,
            'scheduled_at' => $scheduledAt,
        ]);
    }

    /**
     * From Repository
     *
     * @param Request $request
     *
     * @return int
     */
    public function updateNotificationDraft(Request $request): int
    {
        $isScheduled = $request->delayTime > 0;
        $scheduledAt = $isScheduled ? now()->addSeconds(intval($request->delayTime)) : null;
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


        } else {
            if ($request->announceFor == "store") {
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
                'mail_user' => $totalUserMail,
                'updated_at' => $now,
                'scheduled_at' => $scheduledAt,
            ]);
    }

}
