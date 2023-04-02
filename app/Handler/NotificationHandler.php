<?php

namespace App\Handler;

use App\Events\NewEmailMagazineEvent;
use App\Events\NewNotificationFromAdminEvent;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\User\UserController;
use App\Models\User;
use App\Repository\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;
use stdClass;
use function Webmozart\Assert\Tests\StaticAnalysis\lower;

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
    public function loginAdmin(): Application|Factory|View|RedirectResponse
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
    public function handleSubmitLogin(array $request): array
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
    public function reqLogout(): RedirectResponse
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
        $returnData = $this->notificationRepository->getContentUpdateNotificationToView($notificationId);
        $dataNotification = $returnData[0];

        if ($returnData[0]->type == 2) {
            return view('Backend.update-notification-view-2', compact('dataNotification'));
        } else if ($returnData[0]->type == 3) {
            $dataTemplate = $this->notificationRepository->getTemplate();
            return view('Backend.update-notification-view-3', compact('dataNotification', 'dataTemplate'));
        } else {
            return view('Backend.update-notification-view-2', compact('dataNotification'));
        }

    }

    /**
     * @return array
     */
    public function getRegisterLineList(): array
    {
        $listUser = $this->notificationRepository->getAllUser();


        $data = [];
        foreach ($listUser as $subListUser) {

            $line_id = $this->notificationRepository->listConnectLine($subListUser->id);

            if (count($line_id) > 0) {
                $subListUser->line_id = $line_id[0]->line_id;
                $data[count($data)] = $subListUser;
            }
        }

        foreach ($data as $subData) {
            if ($subData->role == 2) {
                $getNameSeeker = $this->notificationRepository->getSeekerNameByUserId($subData->id);
                if (count($getNameSeeker) > 0) {
                    $subData->typeRole = 2;
                    $subData->name = $getNameSeeker[0]->nickname;
                } else {
                    $subData->typeRole = 2;
                    $subData->name = "No has name";
                }

            } else if ($subData->role == 3) {
                $getNameStore = $this->notificationRepository->getStoreNameByUserId($subData->id);
                if (count($getNameStore) > 0) {
                    $subData->typeRole = 3;
                    $subData->name = $getNameStore[0]->store_name;
                } else {
                    $subData->typeRole = 3;
                    $subData->name = "No has name";
                }
            }
        }

        return $data;
    }

    /**
     * @param object $request
     * @return Collection
     */
    public function searchNotification(object $request): Collection
    {
        $textSearch = $request['txt-search-notification'];

        $textSearch == null ? $textSearch = "" : $textSearch;

        $matchedNotifications = $this->notificationRepository->getNotificationBySearch($textSearch);

        foreach ($matchedNotifications as $key => $notification) {
            $typeNotification = $this->notificationRepository->getNotificationTypeById($notification->type)->first();
            $matchedNotifications[$key]->name_type = $typeNotification->type;

            if ($matchedNotifications[$key]->type == 2) {
                $countPerson = $this->notificationRepository->getUsersCreatedBeforeNotificationCurrent($matchedNotifications[$key]->id);

                $countRead = 0;
                foreach ($countPerson as $each_person) {
                    $checkRead = $this->notificationRepository->getNotificationRead($each_person->id, $notification->id);
//                    dump($checkRead);
                    if (count($checkRead) > 0)
                        $countRead += 1;
                }

                $matchedNotifications[$key]->read_user = $countRead;
                $matchedNotifications[$key]->total_user = count($countPerson);

            } else if ($matchedNotifications[$key]->type == 1) {
                $checkRead = $this->notificationRepository->getNotificationReadType1($notification->id);

                $matchedNotifications[$key]->read_user = count($checkRead);

                $matchedNotifications[$key]->total_user = 1;
            }
            if (isset($request->templateType) && $request->templateType != 0) {
                $dataDraft = $this->notificationRepository->getNotificationDraftWithID($matchedNotifications[$key]->notification_draft_id);
                if (isset($matchedNotifications[$key]->notification_draft_id)) {
                    $matchedNotifications[$key]->notification_for = $dataDraft->notification_for;
                    if (!(strtolower($request->templateType) == strtolower($matchedNotifications[$key]->notification_for))) {
                        unset($matchedNotifications[$key]);
                    }
                } else {

                    if (isset($request->templateType)) {
                        unset($matchedNotifications[$key]);
                    }

                }
            }


        }
        return $matchedNotifications;
    }

    /**
     * @param int $notificationType
     * @param String|null $notificationSender
     * @param String|null $notificationTemplate
     * @return View|Factory|RedirectResponse|Application
     */
    public function showSendNotificationView(int $notificationType, string $notificationSender = null, string $notificationTemplate = null): View|Factory|RedirectResponse|Application
    {
        $checkNotificationDraft = $this->notificationRepository->getNotificationDraftForSummaryView();

        if (isset($checkNotificationDraft)) {
            $dataDraft = $this->notificationRepository->getNotificationDraftForSummaryView();
            return view('Backend.draft-notification-view', compact('dataDraft'));
        } else {
            if ($notificationType == 2) {

                if (isset($_GET['messToast'])) {
                    $messToast = $_GET['messToast'];
                    return view('Backend.send-notification-view-2', compact('messToast'));
                } else {
                    return view('Backend.send-notification-view-2');
                }

            } else if ($notificationType == 3) {

                if (isset($_GET['messToast'])) {
                    $messToast = $_GET['messToast'];
                    return view('Backend.send-notification-view-3', compact('messToast'));
                } else {

                    if ($notificationSender != null) {
                        $dataTemplate = $this->notificationRepository->getTemplateByTemplateType($notificationSender);
                        $dataRegion = $this->notificationRepository->getRegion();
                        $dataIndustry = $this->notificationRepository->getIndustry();


                        if ($notificationTemplate != null) {
                            $detailTemplate = $this->notificationRepository->getTemplateFromId($notificationTemplate)->first();
                            return view('Backend.send-notification-view-3', compact('notificationSender', 'dataTemplate', 'detailTemplate', 'dataRegion', 'dataIndustry'));
                        } else {
                            return view('Backend.send-notification-view-3', compact('notificationSender', 'dataTemplate', 'dataRegion', 'dataIndustry'));
                        }
                    } else {
                        return view('Backend.send-notification-view-3');
                    }

                }

            } else {
                return Redirect::to('/admin/notification-list');
            }
        }
    }

    /**
     * @param object $request
     * @return mixed
     */
    public function sendMessForListUser(Request $request): int
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $dataNotificationDraft = $this->notificationRepository->getNotificationDraftWithID($request->notification_draft_id);
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
        $resultRemove = $this->notificationRepository->removeNotificationDraft($request);

        if ($resultRemove) {
            event((new NewNotificationFromAdminEvent($newNotificationId)));
        }

        return $newNotificationId;
    }

    /**
     * @param object $request
     * @return int
     */
    public function saveNotificationDraft(object $request): int
    {
        if ($request->announceFor == "user") {
            if (intval($request->announceTypeFor) == 1) {
                $listSeeker = $this->notificationRepository->getListUserAllRole2();
            } else {
                if (intval($request->areaId) == 0 && intval($request->industryId) == 0) {
                    $listSeeker = $this->notificationRepository->getListUserAllRole2();
                } else {
                    $listSeeker = $this->notificationRepository->getListUserRole2ById($request);
                }
            }

            $totalUserLine = 0;
            $totalUserMail = 0;
            $totalUserSms = 0;
            foreach ($listSeeker as $subListSeeker) {
                if (count($this->notificationRepository->getListUserLine($subListSeeker->id)) > 0) {
                    $totalUserLine += 1;
                } else if ($subListSeeker->email != null) {
                    $totalUserMail += 1;
                } else if ($subListSeeker->phone_number_landline != null) {
                    $totalUserSms += 1;
                }
            }

        } else {
            if ($request->announceTypeFor == 1) {
                $listStore = $this->notificationRepository->getListUserAllRole3();
            } else {
                if (intval($request->areaId) == 0 && intval($request->industryId) == 0) {
                    $listStore = $this->notificationRepository->getListUserAllRole3();
                } else {
                    $listStore = $this->notificationRepository->getListUserRole3ById($request);
                }


            }
            $totalUserLine = 0;
            $totalUserMail = 0;
            $totalUserSms = 0;
            foreach ($listStore as $subListStore) {
                if (count($this->notificationRepository->getListUserLine($subListStore->id)) > 0) {
                    $totalUserLine += 1;
                } else if ($subListStore->mail_address != null) {
                    $totalUserMail += 1;
                } else if ($subListStore->phone_number != null) {
                    $totalUserSms += 1;
                }
            }

        }

        return $this->notificationRepository->saveNotificationDraft($request, $totalUserLine, $totalUserMail, $totalUserSms);
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
    function detailNotification(int $id): Application|Factory|View|RedirectResponse
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
    function deleteNotification(int $notificationId): RedirectResponse
    {
        $this->notificationRepository->deleteNotification($notificationId);
        return Redirect::to('/admin/notification-list');
    }

    /**
     * @return Application|Factory|View
     */
    function showTemplateManagementView(): Application|Factory|View
    {
        $dataTemplate = $this->notificationRepository->getTemplate();
        return view('Backend.template.template-management', compact('dataTemplate'));
    }

    /**
     * @param String $templateType
     * @return Application|Factory|View
     */
    function showAddNewTemplateView(string $templateType): Application|Factory|View
    {
        if ($templateType == "user") {
            $listParam = $this->notificationRepository->getParamUser();
            return view('Backend.template.add-new-template-view', compact('listParam'));
        } elseif ($templateType == "store") {
            $listParam = $this->notificationRepository->getParamStore();
            return view('Backend.template.add-new-template-view', compact('listParam'));
        } else {
            return view('Backend.template.add-new-template-view');
        }
    }

    /**
     * @param String $templateId
     * @return Application|Factory|View
     */
    function showUpdateTemplateView(string $templateId): Application|Factory|View
    {
        $data = $this->notificationRepository->getTemplateFromId($templateId);
        $dataTemplate = $data[0];
        $dataTemplate = $dataTemplate->toArray();
        $listParam = [];
        if (isset($_REQUEST['templateType'])) {
            if ($_REQUEST['templateType'] == "user") {
                $listParam = $this->notificationRepository->getParamUser();
            } elseif ($_REQUEST['templateType'] == "store") {
                $listParam = $this->notificationRepository->getParamStore();
            }
        } else {
            if ($dataTemplate['template_type'] == "user") {
                $listParam = $this->notificationRepository->getParamUser();
            } elseif ($dataTemplate['template_type'] == "store") {
                $listParam = $this->notificationRepository->getParamStore();
            }
        }
        return view('Backend.template.update-template-view', compact('dataTemplate', 'listParam'));
    }

    /**
     * @param object $request
     * @return array
     */
    function reqAddNewTemplate(object $request): array
    {
        $result = $this->notificationRepository->addNewTemplate($request);
        return ['result' => $result];
    }

    /**
     * @param object $request
     * @return array
     */
    function reqUpdateNewTemplate(object $request): array
    {
        $result = $this->notificationRepository->updateTemplate($request);
        return ['result' => $result];
    }

    /**
     * @param object $request
     * @return Collection|stdClass|array
     */
    function getTemplateForSendMail(object $request): Collection|stdClass|array
    {
        $data = $this->notificationRepository->getTemplateForSendMail($request->template_id);

        return $data[0];
    }

    /**
     * @param int $regionId
     * @return Collection|array
     */
    function getAreaFromRegionId(int $regionId): Collection|array
    {
        $regionCd = $this->notificationRepository->getRegionCdFromRegionId($regionId);
        $listPrefId = $this->notificationRepository->getPrefFromRegionCd($regionCd[0]->region_cd);
        $listArea = [];
        foreach ($listPrefId as $subListPrefId) {
            $listArea[count($listArea)] = $this->notificationRepository->getAreaFromRegionId($subListPrefId->id);
        }

//        dump($listArea);

        return $listArea[0];
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

    /**
     * @param Request $request
     * @return int
     */
    public function cancelNotificationDraft(Request $request): int
    {
        return $this->notificationRepository->cancelNotificationDraft($request->notification_draft_id);
    }

    public function renderUpdateNotificationDraft(string $notificationDraftId, string $notificationSender = null, string $notificationTemplate = null)
    {
        $dataDraft = $this->notificationRepository->getNotificationDraftWithID($notificationDraftId);
        $detailTemplate = new stdClass();
        $detailTemplate->id = null;
        $detailTemplate->template_title = $dataDraft->notification_title;
        $detailTemplate->template_content = $dataDraft->notification_content;
        if (isset($dataDraft)) {

            if ($notificationSender != null) {
                $dataTemplate = $this->notificationRepository->getTemplateByTemplateType($notificationSender);
                $dataRegion = $this->notificationRepository->getRegion();
                $dataIndustry = $this->notificationRepository->getIndustry();

                if ($notificationTemplate != null) {
                    $detailTemplate = $this->notificationRepository->getTemplateFromId($notificationTemplate)->first();
                    return view('Backend.update-notification-draft', compact('dataDraft', 'notificationSender', 'dataTemplate', 'detailTemplate', 'dataRegion', 'dataIndustry'));
                } else {

                    return view('Backend.update-notification-draft', compact('dataDraft', 'notificationSender', 'dataTemplate', 'detailTemplate', 'dataRegion', 'dataIndustry'));
                }
            } else {
                return view('Backend.update-notification-draft', compact('dataDraft', 'notificationSender', 'detailTemplate'));
            }
        } else {
            return Redirect::to('/admin/notification-list');

        }

    }

    public function updateNotificationDraft(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'message' => 'required',
        ]);

        if ($request->announceFor == "user") {
            if (intval($request->announceTypeFor) == 1) {
                $listSeeker = $this->notificationRepository->getListUserAllRole2();
            } else {
                if (intval($request->areaId) == 0 && intval($request->industryId) == 0) {
                    $listSeeker = $this->notificationRepository->getListUserAllRole2();
                } else {
                    $listSeeker = $this->notificationRepository->getListUserRole2ById($request);
                }
            }

            $totalUserLine = 0;
            $totalUserMail = 0;
            $totalUserSms = 0;
            foreach ($listSeeker as $subListSeeker) {
                if (count($this->notificationRepository->getListUserLine($subListSeeker->id)) > 0) {
                    $totalUserLine += 1;
                } else if ($subListSeeker->email != null) {
                    $totalUserMail += 1;
                } else if ($subListSeeker->phone_number_landline != null) {
                    $totalUserSms += 1;
                }
            }

        } else {
            if ($request->announceTypeFor == 1) {
                $listStore = $this->notificationRepository->getListUserAllRole3();
            } else {
                if (intval($request->areaId) == 0 && intval($request->industryId) == 0) {
                    $listStore = $this->notificationRepository->getListUserAllRole3();
                } else {
                    $listStore = $this->notificationRepository->getListUserRole3ById($request);
                }


            }
            $totalUserLine = 0;
            $totalUserMail = 0;
            $totalUserSms = 0;
            foreach ($listStore as $subListStore) {
                if (count($this->notificationRepository->getListUserLine($subListStore->id)) > 0) {
                    $totalUserLine += 1;
                } else if ($subListStore->mail_address != null) {
                    $totalUserMail += 1;
                } else if ($subListStore->phone_number != null) {
                    $totalUserSms += 1;
                }
            }

        }
        return $this->notificationRepository->updateNotificationDraft($request, $totalUserLine, $totalUserMail, $totalUserSms);
    }


}
