<?php

namespace App\Http\Controllers\User;

use App\Handler\UserHandler;
use App\Models\User;
use App\Services\LineService;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Session;

use Illuminate\Support\Facades\DB;

use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

// use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use stdClass;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\NotificationController;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

session_start();

class UserController extends Controller
{
    protected const NOTIFICATION_NEW_REGISTER = 1;

    protected const NOTIFICATION_FROM_ADMIN = 2;

    protected const NOTIFICATION_EMAIL_MAGAZINE = 3;

    protected $lineService;
    const CHANNEL_LINE = 1;
    const CHANNEL_EMAIL = 2;
    const CHANNEL_SMS = 3;

    public function __construct(private readonly UserHandler $userHandler)
    {
    }

    public function index(Request $request)
    {
            return $this->userHandler->index($request);
    }

    /**
     * @param Request $request
     * @return View|Factory|Application|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function viewLoginUser(Request $request): View|Factory|Application|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        return $this->userHandler->viewLoginUser($request);
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     */
    public function viewConnectSMS(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        return $this->userHandler->viewConnectSMS();
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     */
    function viewSignupUser(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        return $this->userHandler->viewSignupUser();
    }

    /**
     * @return View|Factory|Application|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    function viewUser(): View|Factory|Application|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        return $this->userHandler->viewUser();
    }

    /**
     * @return Application|Factory|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     */
    function viewAllAnnounceUser(): Application|Factory|View|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        return $this->userHandler->viewAllAnnounceUser();
    }

    public function viewSettingNotification()
    {
        return $this->userHandler->viewSettingNotification();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function connectSMS(Request $request): array
    {
        return $this->userHandler->connectSMS($request);
    }

    /**
     * @throws TwilioException
     */
    public function verifySMS(Request $request): array
    {
        return $this->userHandler->verifySMS($request);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleLineCallback(Request $request): RedirectResponse
    {
        return $this->userHandler->handleLineCallback($request);
    }


    /**
     * @return RedirectResponse
     */
    function logoutUser(): RedirectResponse
    {
        Session::forget('inforUser');
        return Redirect::to('/');
    }

    /**
     * @param Request $request
     * @return array
     */
    function loginUser(Request $request): array
    {
        return $this->userHandler->loginUser($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    function signupUser(Request $request): array
    {
        return UserController::connectSMS($request);
    }


    /**
     * @param Request $request
     * @param $id
     * @return View|Application|Factory
     */
    function detailNotification(Request $request, $id): View|Application|Factory
    {
        return $this->userHandler->detailNotification($request, $id);

    }

    /**
     * @param $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, int $perPage = 10, $page = null,array $options = []): LengthAwarePaginator
    {
        return $this->userHandler->paginate($items, $perPage, $page, $options);
    }
}
