<?php

namespace App\Handler;

use App\Events\NewEmailMagazineEvent;
use App\Events\NewNotificationFromAdminEvent;
use App\Repository\NotificationRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redirect;

use Session;
use stdClass;

class NotificationHandler
{
    protected const NOTIFICATION_NEW_REGISTER = 1;
    protected const NOTIFICATION_FROM_ADMIN = 2;
    protected const NOTIFICATION_EMAIL_MAGAZINE = 3;

    /**
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(private NotificationRepository $notificationRepository)
    {
    }




    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function loginAdmin() : Application|Factory|View|RedirectResponse
    {
        $adminData = Session::get('data_admin');

        if ($adminData) {
            return Redirect::to('/admin/register-line-list');
        } else {
            return view('Backend.login-admin');
        }
    }

    /**
     * @param array $request
     * @return string[]|true[]
     */
    public function handleSubmitLogin(array $request) : array
    {
        $dataAdmin = $this->notificationRepository->handleSubmitLogin($request);

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
    public function reqLogout() : RedirectResponse
    {
        Session::forget('data_admin');
        return Redirect::to('/admin');
    }

    /**
     * @param int $notificationId
     * @return View|Factory|RedirectResponse|Application
     */
    public function showContentUpdateNotificationToView(int $notificationId): View|Factory|RedirectResponse|Application
    {
        $returnData =  $this->notificationRepository->getContentUpdateNotificationToView($notificationId);
        $dataNotification = $returnData[0];

        if($returnData[0]->type == 2) {
            return view('Backend.update-notification-view-2', compact('dataNotification'));
        } else if($returnData[0]->type == 3) {
            $dataTemplate = $this->notificationRepository->getTemplate();
            return view('Backend.update-notification-view-3', compact('dataNotification', 'dataTemplate'));
        } else {
            return view('Backend.update-notification-view-2', compact('dataNotification'));
        }

    }

    /**
     * @return array
     */
    public function getRegisterLineList() : array
    {
        $data =  $this->notificationRepository->listConnectLine();
        $List = [];

        foreach ($data as $subData) {
            $displayName = $this->notificationRepository->getUserNameByUserId($subData->user_id);
            $subData->displayName = $displayName;
            $List[count($List)] = $subData;
        }

        return $List;
    }

    /**
     * @param object $request
     * @return Collection
     */
    public function searchNotification(object $request) : Collection
    {
        $textSearch = $request['txt-search-notification'];

        $textSearch == null ? $textSearch = "" : $textSearch;

        $matchedNotifications = $this->notificationRepository->getNotificationBySearch($textSearch);

        foreach ($matchedNotifications as $key => $notification)
        {
            $typeNotification = $this->notificationRepository->getNotificationTypeById($notification->type)->first();
            $matchedNotifications[$key]->name_type = $typeNotification->type;

            if ($matchedNotifications[$key]->type == 2)
            {
                $countPerson = $this->notificationRepository->getUsersCreatedBeforeNotificationCurrent($matchedNotifications[$key]->created_at);

                $countRead = 0;
                foreach ($countPerson as $each_person) {
                    $checkRead = $this->notificationRepository->getNotificationRead($each_person->user_id, $notification->id);

                    if (count($checkRead) > 0)
                        $countRead += 1;
                }

                $matchedNotifications[$key]->read_user = $countRead;
                $matchedNotifications[$key]->total_user = count($countPerson);

            }
            else if ($matchedNotifications[$key]->type == 3)
            {

                $countPerson = $this->notificationRepository->getUsersCreatedBeforeNotificationEmailCurrent($matchedNotifications[$key]->created_at);

                $countRead = 0;
                foreach ($countPerson as $key_2 => $each_person) {
                    $checkRead = $this->notificationRepository->getNotificationRead($each_person->user_id, $notification->id);

                    if (count($checkRead) > 0)
                        $countRead += 1;
                }

                $matchedNotifications[$key]->read_user = $countRead;
                $matchedNotifications[$key]->total_user = count($countPerson);
            }

        }

        return $matchedNotifications;
    }

    /**
     * @param $notificationType
     * @return View|Factory|RedirectResponse|Application
     */
    public function showSendNotificationView($notificationType) :View|Factory|RedirectResponse|Application
    {

        if ($notificationType == 2) {

            if (isset($_GET['messToast'])) {
                $messToast = $_GET['messToast'];
                return view('Backend.send-notification-view-2', compact('messToast'));
            } else {
                return view('Backend.send-notification-view-2');
            }

        }
        else if ($notificationType == 3)
        {
            $dataTemplate = $this->notificationRepository->getTemplate();

            if (isset($_GET['messToast'])) {
                $messToast = $_GET['messToast'];

                return view('Backend.send-notification-view-3', compact('dataTemplate', 'messToast'));

            } else {
                return view('Backend.send-notification-view-3', compact('dataTemplate'));
            }

        }
        else
        {
            return Redirect::to('/admin/notification-list');
        }

    }

    /**
     * @param object $request
     * @return mixed
     */
    public function sendMessForListUser(object $request) : int
    {
        $newNotificationId = $this->notificationRepository->insertDataNotification($request);

        if (intval($request->type_notification) === self::NOTIFICATION_EMAIL_MAGAZINE) {
            event((new NewEmailMagazineEvent($newNotificationId)));
        } else if (intval($request->type_notification) === self::NOTIFICATION_FROM_ADMIN) {
            event((new NewNotificationFromAdminEvent($newNotificationId)));
        }

        return $newNotificationId;
    }

    /**
     * @param object $request
     * @return int
     */
    function sendUpdateForListUser(object $request): int
    {
        return $this->notificationRepository->updateNotificationForListUser($request);
    }

    /**
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     */
    function detailNotification(int $id) : Application|Factory|View|RedirectResponse
    {
        $dataAdmin = Session::get('data_admin');

        if ($dataAdmin) {
            $notification = $this->notificationRepository->getNotificationFromId($id);
            $typeNotification = $this->notificationRepository->getTypeNameFromTypeNotification($notification[0]->type);

            if (count($typeNotification) > 0) {
                $notification[0]->name_type = $typeNotification[0]->type;
            }
            $notification = $notification[0];

            return view("Backend.view-announce-admin-detail", compact('notification'));
        } else {
            return Redirect::to('/');
        }

    }

    /**
     * @param int $notificationId
     * @return RedirectResponse
     */
    function deleteNotification(int $notificationId) : RedirectResponse
    {
        $this->notificationRepository->deleteNotification($notificationId);
        return Redirect::to('/admin/notification-list');
    }

    /**
     * @return Application|Factory|View
     */
    function showTemplateManagementView() :Application|Factory|View
    {
        $dataTemplate = $this->notificationRepository->getTemplate();
        return view('Backend.template.template-management', compact('dataTemplate'));
    }

    /**
     * @return Application|Factory|View
     */
    function showAddNewTemplateView() : Application|Factory|View
    {
        $dataRegion = $this->notificationRepository->getRegion();
        $dataArea = $this->notificationRepository->getArea();
        $dataIndustry = $this->notificationRepository->getIndustry();
        $dataStore = $this->notificationRepository->getStore();

        return view('Backend.template.add-new-template-view', compact('dataRegion', 'dataArea', 'dataIndustry', 'dataStore'));
    }

    /**
     * @param String $templateId
     * @return Application|Factory|View
     */
    function showUpdateTemplateView(String $templateId) : Application|Factory|View
    {
        $data = $this->notificationRepository->getTemplateFromId($templateId);
        $dataTemplate = $data[0];

        $dataRegion = $this->notificationRepository->getRegion();
        $dataArea = $this->notificationRepository->getArea();
        $dataIndustry = $this->notificationRepository->getIndustry();
        $dataStore = $this->notificationRepository->getStore();

        return view('Backend.template.update-template-view', compact('dataTemplate', 'dataRegion', 'dataArea', 'dataIndustry', 'dataStore'));
    }

    /**
     * @param object $request
     * @return array
     */
    function reqAddNewTemplate(object $request) : array
    {
        $result = $this->notificationRepository->addNewTemplate($request);
        return ['result' => $result];
    }

    /**
     * @param object $request
     * @return array
     */
    function reqUpdateNewTemplate(object $request) : array
    {
        $result = $this->notificationRepository->updateTemplate($request);
        return ['result' => $result];
    }

    /**
     * @param object $request
     * @return Collection|stdClass
     */
    function getTemplateForSendMail(object $request) : Collection|stdClass
    {
        $data = $this->notificationRepository->getTemplateForSendMail($request->template_id);

        return $data[0];
    }









    /**
     * @param int $status
     * @return array
     */
    public function listUser(int $status): array
    {
        $data = $this->notificationRepository->getDataNotificationUserSetting($status);

        $List = [];
        foreach ($data as $subData) {
            $dataTmpUser = $this->notificationRepository->getDataNotificationUserInfo($subData->user_id);

            $subData->displayName = $dataTmpUser[0]->displayName;

            $List[] = $subData;
        }
        return $List;
    }

}
