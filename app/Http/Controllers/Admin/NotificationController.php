<?php

namespace App\Http\Controllers\Admin;

use App\Events\NewStoreRequestRegistrationEvent;
use App\Handler\NotificationHandler;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserController;
use App\Services\NotificationUserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

/**
 *
 */
class NotificationController extends Controller
{
    /**
     * @param NotificationHandler $notificationHandler
     * @param NotificationUserService $notificationUserService
     */
    public function __construct(
        private NotificationHandler $notificationHandler,
        private NotificationUserService $notificationUserService

    ) {
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    function loginAdmin(): View|Factory|RedirectResponse|Application
    {
        return $this->notificationUserService->loginAdmin();
    }

    /**
     * @param Request $request
     *
     * @return string[]|true[]
     */
    function handleSubmitLogin(Request $request): array
    {
        $validated = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required|max:255',
        ]);

        return $this->notificationUserService->handleSubmitLogin($validated);
    }

    /**
     * @return RedirectResponse
     */
    public function reqLogout(): RedirectResponse
    {
        return $this->notificationUserService->reqLogout();
    }


    /**
     * @return Application|Factory|View|
     */
    function registerLineList(): Factory|View|Application
    {
        $dataList = $this->notificationHandler->getRegisterLineList();
        return view('admin.notification.register-line-list', compact("dataList"));
    }

    /**
     * @param $items
     * @param int $perPage
     * @param $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, int $perPage = 20, $page = null, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    function notificationList(Request $request): View|Factory|RedirectResponse|Application
    {
        $data_admin = Session::get('data_admin');

        if ($data_admin) {
            $dataList = $this->notificationHandler->searchNotification($request);
            $dataList = $this->paginate($dataList);
            $dataList->withPath('/admin/notification-list');
            return view('admin.notification.notification-list', compact('dataList'));
        } else {
            return Redirect::to('/admin');
        }
    }

    /**
     * @param int $notificationType
     * @param string|null $notificationSender
     * @param string|null $notificationTemplate
     * @return Application|Factory|View|RedirectResponse
     */
    function showSendNotificationView(
        int $notificationType,
        string $notificationSender = null,
        string $notificationTemplate = null
    ): View|Factory|RedirectResponse|Application {
        return $this->notificationHandler->showSendNotificationView(
            $notificationType,
            $notificationSender,
            $notificationTemplate
        );
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    function sendMessForListUser(Request $request): int
    {
        return $this->notificationHandler->sendMessForListUser($request);
    }

    /**
     * @param int $notificationId
     * @return Application|Factory|View|RedirectResponse
     */
    function showContentUpdateNotificationToView(int $notificationId): Application|Factory|View|RedirectResponse
    {
        return $this->notificationHandler->showContentUpdateNotificationToView($notificationId);
    }

    /**
     * @param Request $request
     * @return int
     */
    function sendUpdateForListUser(Request $request): int
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required',
        ]);
        return $this->notificationHandler->sendUpdateForListUser($request);
    }

    /**
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     */
    function detailNotification(int $id): Application|Factory|View|RedirectResponse
    {
        return $this->notificationHandler->detailNotification($id);
    }

    /**
     * @param int $notificationId
     * @return RedirectResponse
     */
    function deleteNotification(int $notificationId): RedirectResponse
    {
        return $this->notificationHandler->deleteNotification($notificationId);
    }

    /**
     * @param Request $request
     * @return Collection|array
     */
    function getAreaFromRegionId(Request $request): Collection|array
    {
        $request->validate([
            'regionId' => 'max:10'
        ]);
        return $this->notificationHandler->getAreaFromRegionId($request->regionId);
    }

    /**
     * @param string $smsNumber
     * @param string $message
     *
     * @return void
     */
    static public function sendMessTwilio(string $smsNumber, string $message): void
    {
        event(new NewStoreRequestRegistrationEvent(UserController::CHANNEL_SMS, $smsNumber, "", $message));
    }
}
