<?php

namespace App\Repository;

use App\Models\NotificationDraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationDraftRepository
{
    public function __construct(
        private NotificationUserLineRepository $notificationUserLineRepository
    )
    {
    }


    /**
     * @param string $notificationDraftId
     *
     * @return NotificationDraft|null
     */
    public function getNotificationDraftWithID(string $notificationDraftId): ?NotificationDraft
    {
        return NotificationDraft::find($notificationDraftId);
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



}
