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
use App\Services\NotificationUserService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NotificationTemplateHandler
{
    /**
     * @param NotificationRepository $notificationRepository
     * @param NotificationReadRepository $notificationReadRepository
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
        private NotificationTemplateRepository $notificationTemplateRepository,
        private NotificationTypeRepository $notificationTypeRepository,
        private NotificationDraftRepository $notificationDraftRepository,
        private NotificationParamStoreRepository $notificationParamStoreRepository,
        private NotificationParamUserRepository $notificationParamUserRepository,
        private NotificationUserService $notificationUserService
    ) {
    }

    /**
     * @return Application|Factory|View
     */
    function showTemplateManagementView(): Application|Factory|View
    {
        $dataTemplate = $this->notificationTemplateRepository->getAllTemplate();

        return view('admin.notification.template.template-management', compact('dataTemplate'));
    }

    /**
     * @param string $templateType
     *
     * @return Application|Factory|View
     */
    function showAddNewTemplateView(string $templateType): Application|Factory|View
    {
        if ($templateType == "user") {
            $listParam = $this->notificationParamUserRepository->getAll();
            return view('admin.notification.template.add-new-template-view', compact('listParam'));
        } elseif ($templateType == "store") {
            $listParam = $this->notificationParamStoreRepository->getAll();
            return view('admin.notification.template.add-new-template-view', compact('listParam'));
        } else {
            return view('admin.notification.template.add-new-template-view');
        }
    }

    /**
     * @param string $templateId
     *
     * @return Application|Factory|View
     */
    function showUpdateTemplateView(string $templateId): Application|Factory|View
    {
        $data = $this->notificationTemplateRepository->getDetail($templateId);
        $dataTemplate = $data;
        $dataTemplate = $dataTemplate->toArray();
        $listParam = [];
        if (isset($_REQUEST['templateType'])) {
            if ($_REQUEST['templateType'] == "user") {
                $listParam = $this->notificationParamUserRepository->getAll();
            } elseif ($_REQUEST['templateType'] == "store") {
                $listParam = $this->notificationParamStoreRepository->getAll();
            }
        } else {
            if ($dataTemplate['template_type'] == "user") {
                $listParam = $this->notificationParamUserRepository->getAll();
            } elseif ($dataTemplate['template_type'] == "store") {
                $listParam = $this->notificationParamStoreRepository->getAll();
            }
        }
        return view('admin.notification.template.update-template-view',
            compact('dataTemplate', 'listParam'));
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    function reqAddNewTemplate(Request $request): array
    {
        $result = $this->notificationTemplateRepository->add($request);
        return ['result' => $result];
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    function reqUpdateNewTemplate(Request $request): array
    {
        $result = $this->notificationTemplateRepository->update($request);
        return ['result' => $result];
    }

    /**
     * @param Request $request
     *
     * @return NotificationTemplate
     */
    function getTemplateForSendMail(Request $request): NotificationTemplate
    {
        return $this->notificationTemplateRepository->getTemplateForSendMail($request->get('template_id'));
    }
}
