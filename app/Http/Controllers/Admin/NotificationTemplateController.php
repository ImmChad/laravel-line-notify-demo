<?php

namespace App\Http\Controllers\Admin;

use App\Handler\NotificationTemplateHandler;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 *
 */
class NotificationTemplateController extends Controller
{
    /**
     * @param NotificationTemplateHandler $notificationTemplateHandler
     */
    public function __construct(
        private NotificationTemplateHandler $notificationTemplateHandler
    )
    {
    }

    /**
     * @return Application|Factory|View
     */
    function showTemplateManagementView() : Application|Factory|View
    {
        return $this->notificationTemplateHandler->showTemplateManagementView();
    }

    /**
     * @return Application|Factory|View
     */
    function showAddNewTemplateView() : Application|Factory|View
    {
        if(!isset($_GET['templateType'])) {
            $templateType = "";
        } else {
            $templateType = $_GET['templateType'];
        }
        return $this->notificationTemplateHandler->showAddNewTemplateView($templateType);
    }

    /**
     * @param $templateId
     * @return Application|Factory|View
     */
    function showUpdateTemplateView($templateId) : Application|Factory|View
    {
        return $this->notificationTemplateHandler->showUpdateTemplateView($templateId);
    }

    /**
     * @param Request $request
     * @return array
     */
    function reqAddNewTemplate(Request $request) : array
    {
        $request->validate([
            'templateName' => 'required|max:255',
            'templateTitle' => 'required',
            'templateContent' => 'required'
        ]);
        return $this->notificationTemplateHandler->reqAddNewTemplate($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function reqUpdateNewTemplate(Request $request) : array
    {
        $request->validate([
            'templateName' => 'required|max:255',
            'templateTitle' => 'required',
            'templateContent' => 'required'
        ]);
        return $this->notificationTemplateHandler->reqUpdateNewTemplate($request);
    }

    /**
     * @param Request $request
     * @return Collection|stdClass|array
     */
    function getTemplateForSendMail(Request $request) : Collection|stdClass|array
    {
        return $this->notificationTemplateHandler->getTemplateForSendMail($request);
    }
}
