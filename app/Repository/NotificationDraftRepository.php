<?php

namespace App\Repository;

use App\Models\NotificationDraft;
use App\Services\NotificationUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationDraftRepository
{
    public function __construct(
        private NotificationUserService $notificationUserService,
        private NotificationUserLineRepository $notificationUserLineRepository
    )
    {
    }

    /**
     * @param object $request
     *
     * @return int
     */
    public function saveNotificationDraft(object $request): int {
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
                $this->notificationUserService->getSeekerHasLineWithAreaIDIndustryIDCreatedAt($request->areaId, $request->industryId, $now)
            );
        } else {
            if ("store" === $request->announceFor) {
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
     * @param Request $request
     *
     * @return int
     */
    public function updateNotificationDraft(Request $request): int {
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

    /**
     * @param Request $request
     *
     * @return int
     */
    public function removeNotificationDraft(Request $request): int
    {
        return DB::table('notification_draft')
            ->where(["id" => $request->notification_draft_id])
            ->update(["is_processed" => 1]);
    }

    /**
     * @return NotificationDraft|null
     */
    public function getNotificationDraftForSummaryView(): ?NotificationDraft
    {
        $dataDraft = DB::table('notification_draft')->where(['is_processed' => 0])->orderBy('created_at', 'DESC')->get(
        )->first();

        if (null !== $dataDraft) {
            if ($dataDraft->notification_for == "user") {
                $dataDraft->lineUsers = $this->notificationUserService->getSeekerHasLineWithAreaIDIndustryIDCreatedAt(
                    $dataDraft->area_id,
                    $dataDraft->industry_id,
                    $dataDraft->created_at
                );
                $dataDraft->emailUsers = $this->notificationUserService->getSeekerNotLineHasMailWithAreaIDIndustryIDCreatedAt(
                    $dataDraft->area_id,
                    $dataDraft->industry_id,
                    $dataDraft->created_at
                );
                $dataDraft->smsUsers = $this->notificationUserService->getSeekerOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt(
                    $dataDraft->area_id,
                    $dataDraft->industry_id,
                    $dataDraft->created_at
                );
            } else {
                if ($dataDraft->notification_for == "store") {
                    $dataDraft->lineUsers = $this->notificationUserService->getStoreHasLineWithAreaIDIndustryIDCreatedAt(
                        $dataDraft->area_id,
                        $dataDraft->industry_id,
                        $dataDraft->created_at
                    );
                    $dataDraft->emailUsers = $this->notificationUserService->getStoreNotLineHasMailWithAreaIDIndustryIDCreatedAt(
                        $dataDraft->area_id,
                        $dataDraft->industry_id,
                        $dataDraft->created_at
                    );
                    $dataDraft->smsUsers = $this->notificationUserService->getStoreOnlyHasPhoneNumberWithAreaIDIndustryIDCreatedAt(
                        $dataDraft->area_id,
                        $dataDraft->industry_id,
                        $dataDraft->created_at
                    );
                }
            }
        }

        return $dataDraft;
    }

    /**
     * @param string $notificationDraftId
     *
     * @return NotificationDraft|null
     */
    public function getNotificationDraftWithID(string $notificationDraftId): ?NotificationDraft
    {
        return DB::table('notification_draft')
            ->where(["id" => $notificationDraftId])
            ->orderBy('created_at','DESC')
            ->get()
            ->first();
    }

    /**
     * @param string $id
     *
     * @return int
     */
    public function cancelNotificationDraft(string $id): int
    {
        return DB::statement("DELETE FROM notification_draft WHERE id = ?", [$id]);
    }
}
