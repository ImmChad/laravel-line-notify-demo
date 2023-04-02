<?php

namespace App\Http\Controllers\Admin;

use App\Handler\NotificationDraftHandler;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 *
 */
class NotificationDraftController extends Controller
{
    /**
     * @param NotificationDraftHandler $notificationDraftHandler
     */
    public function __construct(
        private NotificationDraftHandler $notificationDraftHandler
    )
    {
    }

    /**
     * @param Request $request
     * @return int
     */
    function cancelNotificationDraft(Request $request): int
    {
        return $this->notificationDraftHandler->cancelNotificationDraft($request);
    }

    /**
     * @param string $notificationDraftId
     * @param string|null $notificationSender
     * @param string|null $notificationTemplate
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse
     */
    function renderUpdateNotificationDraft(
        string $notificationDraftId,
        string $notificationSender = null,
        string $notificationTemplate = null
    ): \Illuminate\Foundation\Application|View|Factory|RedirectResponse|Application {
        return $this->notificationDraftHandler->renderUpdateNotificationDraft(
            $notificationDraftId,
            $notificationSender,
            $notificationTemplate
        );
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    function updateNotificationDraft(Request $request): int
    {
        return $this->notificationDraftHandler->updateNotificationDraft($request);
    }

    /**
     * @param Request $request
     * @return int
     */
    function saveNotificationDraft(Request $request): int
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
        ]);
        return $this->notificationDraftHandler->saveNotificationDraft($request);
    }
}
