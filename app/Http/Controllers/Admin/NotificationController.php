<?php

namespace App\Http\Controllers\Admin;

use App\Handler\NotificationHandler;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Session;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

/**
 *
 */
class NotificationController extends Controller
{
    /**
     * @param NotificationHandler $notificationHandler
     */
    public function __construct(private NotificationHandler $notificationHandler)
    {
    }


    /**
     * @return Application|Factory|View|RedirectResponse
     */
    function loginAdmin(): View|Factory|RedirectResponse|Application
    {
        return $this->notificationHandler->loginAdmin();
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
        return $this->notificationHandler->handleSubmitLogin($validated);
    }

    /**
     * @return RedirectResponse
     */
    public function reqLogout() : RedirectResponse
    {
        return $this->notificationHandler->reqLogout();
    }


    /**
     * @return Application|Factory|View|
     */
    function registerLineList(): Factory|View|Application
    {
        $dataList = $this->notificationHandler->getRegisterLineList();
        return view('Backend.register-line-list', compact("dataList"));
    }

    /**
     * @param $items
     * @param int $perPage
     * @param $page
     * @param array $options
     *
     * @return LengthAwarePaginator
     */
    public function paginate($items, int $perPage = 10, $page = null, array $options = []): LengthAwarePaginator
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
            return view('Backend.notification-list', compact('dataList'));
        } else {
            return Redirect::to('/admin');
        }

    }

    /**
     * @param $notificationType
     * @return Application|Factory|View|RedirectResponse
     */
    function showSendNotificationView($notificationType): View|Factory|RedirectResponse|Application
    {
        return $this->notificationHandler->showSendNotificationView($notificationType);
    }

    /**
     * @param Request $request
     *
     * @return int
     */
    function sendMessForListUser(Request $request): int
    {
        $request->validate([
            'title' => 'required|max:255',
            'message' => 'required|max:255',
        ]);
        return $this->notificationHandler->sendMessForListUser($request);
    }

    /**
     * @param $notificationId
     * @return Application|Factory|View|RedirectResponse
     */
    function showContentUpdateNotificationToView($notificationId) :Application|Factory|View|RedirectResponse
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
            'title' => 'required|max:255',
            'message' => 'required|max:255',
        ]);
        return $this->notificationHandler->sendUpdateForListUser($request);
    }

    /**
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     */
    function detailNotification(int $id) : Application|Factory|View|RedirectResponse
    {
        return $this->notificationHandler->detailNotification($id);
    }

    /**
     * @param int $notification_id
     * @return RedirectResponse
     */
    function deleteNotification(int $notificationId) : RedirectResponse
    {
        return $this->notificationHandler->deleteNotification($notificationId);
    }

    /**
     * @return Application|Factory|View
     */
    function showTemplateManagementView() : Application|Factory|View
    {
        return $this->notificationHandler->showTemplateManagementView();
    }

    /**
     * @return Application|Factory|View
     */
    function showAddNewTemplateView() : Application|Factory|View
    {
        return $this->notificationHandler->showAddNewTemplateView();
    }

    /**
     * @param $template_id
     * @return Application|Factory|View
     */
    function showUpdateTemplateView($templateId) : Application|Factory|View
    {
        return $this->notificationHandler->showUpdateTemplateView($templateId);
    }

    /**
     * @param Request $request
     * @return array
     */
    function reqAddNewTemplate(Request $request) : array
    {
        $request->validate([
            'template_name' => 'required|max:255',
            'template_title' => 'required|max:255',
            'template_content' => 'required|max:255'
        ]);
        return $this->notificationHandler->reqAddNewTemplate($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function reqUpdateNewTemplate(Request $request) : array
    {
        $request->validate([
            'template_name' => 'required|max:255',
            'template_title' => 'required|max:255',
            'template_content' => 'required|max:255'
        ]);
        return $this->notificationHandler->reqUpdateNewTemplate($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    function getTemplateForSendMail(Request $request) : array
    {
        return $this->notificationHandler->getTemplateForSendMail($request);
    }





    // FIX HERRE
    /**
     * @param $sms_number
     * @param $message
     * @return void
     * @throws ConfigurationException
     * @throws TwilioException
     */
    static public function sendMessTwilio($sms_number, $message)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $res = $client->messages
            ->create($sms_number, // to
                [
                    "body" => $message,
                    "messagingServiceSid" => $twilio_number = getenv("TWILIO_SMS_SERVICE_ID")
                ]
            );
    }
}
