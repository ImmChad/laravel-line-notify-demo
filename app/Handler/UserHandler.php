<?php

namespace App\Handler;

use App\Events\NewStoreRequestRegistration;
use App\Http\Controllers\User\UserController;
use App\Repository\NotificationDraftRepository;
use App\Repository\NotificationRepository;
use App\Repository\NotificationTypeRepository;
use App\Repository\UserRepository;
use App\Services\LineService;
use App\Services\NotificationService;
use App\Services\NotificationUserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class UserHandler
{
    public const NOTIFICATION_NEW_REGISTER = 1;

    const CHANNEL_SMS = 3;

    public function __construct(
        private UserRepository $userRepository,
        private NotificationRepository $notificationRepository,
        private NotificationDraftRepository $notificationDraftRepository,
        private NotificationTypeRepository $notificationTypeRepository,
        private NotificationUserService $notificationUserService,
        private LineService $lineService
    ) {
    }


    /**
     * @param Request $request
     *
     * @return View|Application|Factory
     */

    public function index(): View|Application|Factory
    {
        $inforUser = Session::get('inforUser');
        $authUrl = $this->lineService->getLoginBaseUrl();
        $authGmail = 'authorized/google';
        $announceCount = self::checkAnnounceCount();

        return view('seeker.notification.view-user', compact(['authUrl', 'authGmail']))->with(["dataUser" => $inforUser])->with(
            ['announceCount' => $announceCount]
        );
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */


    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        $user = Socialite::driver('google')->stateless()->user();
        $inforUser = Session::get('inforUser');

        $inforUser['address'] = $user->email;
        $inforUser['pictureUrl'] = $user->avatar;

        $email = $user->email;
        $displayName = $user->name;
        $textNotification = 'Hello ' . $displayName . ', click on this link to see notifications about new users.';
        $titleSubject = "Notification";
        $this->userRepository->updateEmailUserCaseConnectMail($inforUser['id'], $email);
        $this->userRepository->updateEmailStoreCaseConnectMail($inforUser['id'], $email);

        event(new NewStoreRequestRegistration(UserController::CHANNEL_EMAIL, $email, $titleSubject, $textNotification));

        return Redirect::to('/user');
    }

    /**
     * @param Request $request
     * @return View|Application|Factory|RedirectResponse
     */
    public function viewLoginUser(Request $request): View|Application|Factory|RedirectResponse
    {
        $user = DB::table("user")->where('id', 'fca6e441-89c6-449f-a701-4ccca56686dc')->first();
        $user = json_decode(json_encode($user), true);
        if ($user['email'] != "" || $user['email'] != null) {
            $user['email'] = Crypt::decryptString($user['email']);
        } else {
            $user['email'] = "";
        }

        if ($user['phone_number_landline'] != "" || $user['phone_number_landline'] != null) {
            $user['phone_number_landline'] = Crypt::decryptString($user['phone_number_landline']);
        } else {
            $user['phone_number_landline'] = "";
        }

        $request->session()->put("inforUser", $user);

        $inforUser = Session::get('inforUser');
        if ($inforUser) {
            return Redirect::to('/user');
        } else {
            return view('seeker.notification.login-user');
        }
    }


    /**
     * @return View|Application|Factory|RedirectResponse
     */
    public function viewConnectSMS(): View|Application|Factory|RedirectResponse
    {
        $inforUser = Session::get('inforUser');
        if ($inforUser) {
            return Redirect::to('/user');
        } else {
            return view('seeker.notification.view-register-sms');
        }
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     */
    function viewSignupUser(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $inforUser = Session::get('inforUser');
        if ($inforUser) {
            return Redirect::to('/user');
        } else {
            return view('seeker.notification.signup-user');
        }
    }

    function getAnnounceContent(): array
    {
        $inforUser = Session::get('inforUser');
        $notifications = $this->userRepository->getNotificationExceptNewRegisterBefore($inforUser['created_at']);
        $ListData = [];
        $notifications = array_filter($notifications->toArray(), function ($notification) use ($inforUser) {
            $dataUsers = $this->notificationUserService->getUsersCreatedBeforeNotificationCurrent(
                $notification->id
            )->toArray();
            $userIds = array_map(
                function ($dataUser) {
                    return $dataUser->id;
                },
                $dataUsers
            );
            foreach ($userIds as $userId) {
                if ($inforUser['id'] == $userId) {
                    return $notification;
                }
            }
        });

        foreach ($notifications as $notification) {
            $inforUser = Session::get('inforUser');
            $dataAnnounce = $this->userRepository->getNotificationReadWithUserIdNotificationId(
                $notification->id,
                $inforUser['id']
            );
            if (count($dataAnnounce) > 0) {
                $notification->read_at = $dataAnnounce[0]->read_at;
            } else {
                $notification->read_at = "null";
            }
            $ListData[count($ListData)] = $notification;
        }

        return $ListData;
    }

    /**
     * @param Request $request
     * @param $id
     * @return View|Application|Factory
     */
    function detailNotification(Request $request, $id): View|Application|Factory
    {
        $inforUser = Session::get('inforUser');
        $notification = $this->userRepository->getNotificationBeforeUserCreatedAtWithId($id, $inforUser['created_at']);

        $this->userRepository->insertNotificationRead($id, $inforUser['id']);
        $type_notification = $this->notificationTypeRepository->getDetail($notification->type)->first();

        $notification->name_type = $type_notification->type;
        $notificationService = new NotificationService($this->notificationRepository);
        $dataDraft = $this->notificationDraftRepository->getNotificationDraftWithID($notification->notification_draft_id);
        if (isset($dataDraft)) {
            if ($dataDraft->notification_for == "user") {
                $notification->announce_title = $notificationService->loadParamNotificationUser(
                    $notification->announce_title,
                    $inforUser['id'],
                    "mail"
                );
                $notification->announce_content = $notificationService->loadParamNotificationUser(
                    $notification->announce_content,
                    $inforUser['id'],
                    "mail"
                );
            } else {
                if ($dataDraft->notification_for == "store") {
                    $dataStore = $this->notificationUserService->getFirstStoreWithUserID($inforUser['id']);
                    $notification->announce_title = $notificationService->loadParamNotificationStore(
                        $notification->announce_title,
                        $dataStore->id,
                        "mail"
                    );
                    $notification->announce_content = $notificationService->loadParamNotificationStore(
                        $notification->announce_content,
                        $dataStore->id,
                        "mail"
                    );
                }
            }
        }

        $dataList = self::getAnnounceContent();
        $dataList = $this->paginate($dataList);
        $dataList->withPath('/user/notify/list');
        $announceCount = self::checkAnnounceCount();

        return view("Frontend.view-announce-user-detail", compact('dataList', 'announceCount'))->with(
            ['notification' => $notification]
        );
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleLineCallback(Request $request): RedirectResponse
    {
        $code = $request->input('code', '');
        $inforUser = Session::get('inforUser');
        $response = $this->lineService->getLineToken($code);
        // Get profile from ID token
        $profile1 = $this->lineService->verifyIDToken($response['id_token']);
        // Get profile from access token.
        $profile = $this->lineService->getUserProfile($response['access_token']);
        $profile['email'] = $profile1['email'];

        if (!isset($profile['pictureUrl'])) {
            $profile['pictureUrl'] = "";
        }
        if (!isset($profile['email'])) {
            $profile['email'] = "";
        }
//        dd($profile);
        $this->userRepository->insertNotificationUserLine($inforUser['id'], $profile['userId']);
        self::sendMessForUser($profile['userId'], $profile['displayName']);

        return Redirect::to('/user');
    }

    /**
     * @param $userId
     * @param $displayName
     * @return TextMessageBuilder
     */
    function sendMessForUser($userId, $displayName): TextMessageBuilder
    {
        $httpClient = new CurlHTTPClient(env('LINE_BOT_CHANNEL_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_BOT_CHANNEL_SECRET')]);

        $userIds = $userId;
        $titleSubject = "Notification";
        $textNotification = 'Hello ' . $displayName . ', click on this link to see notifications about new users.';
        $this->notificationRepository->insertDataNotification([
            'type' => self::NOTIFICATION_NEW_REGISTER,
            'announce_title' => $titleSubject,
            'announce_content' => $textNotification,
            'created_at' => date('Y/m/d H:i:s'),
            'is_sent' => true,
            'is_scheduled' => false,
            'scheduled_at' => null
        ]);
        $message = new TextMessageBuilder($textNotification);

        $bot->pushMessage($userIds, $message);


        return $message;
    }

    /**
     * @return View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    function viewAllAnnounceUser(
    ): View|Application|Factory|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $inforUser = Session::get('inforUser');
        if ($inforUser) {
            $dataList = self::getAnnounceContent();
            $dataList = $this->paginate($dataList);
            $dataList->withPath('/user/notify/list');
            $announceCount = self::checkAnnounceCount();
            return view('seeker.notification.view-announce-user', compact('announceCount'))->with(["dataList" => $dataList]);
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * @param $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, int $perPage = 10, $page = null, $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function viewSettingNotification(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $authUrl = $this->lineService->getLoginBaseUrl();
        $authGmail = 'authorized/google';
        $announceCount = self::checkAnnounceCount();
        return view('seeker.notification.setting-connect-user', compact(['authUrl', 'authGmail', 'announceCount']));
    }

    /**
     * @param Request $request
     * @return array
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function connectSMS(Request $request): array
    {
//        $this->validate($request, [
//            'number_sms' => 'required|regex:/^([0-9\s\+\(\)]*)$/|min:10'
//        ]);
        $number_sms_nospace = str_replace(' ', '', $request->number_sms);
        $user = DB::table('notification_user_info')
            ->where(['phone_number' => $number_sms_nospace])
            ->first();
        if (isset($user)) {
            return ["SMSExisted" => isset($user), 'mess' => "Phone Number used"];
        }
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $client = new Client($account_sid, $auth_token);
        try {
            $verification = $client->verify->v2->services(getenv("TWILIO_VERIFY_SERVICE_ID"))
                ->verifications
                ->create($number_sms_nospace, "sms");
        } catch (RestException $th) {
            return [
                "valid" => false,
                "mess" => "Phone Number Invalid"
            ];
        }
        $request->session()->put(
            'register-SMS'
            ,
            [
                'number-SMS' => $number_sms_nospace,
                'displayName' => $request->displayName,
                'password' => $request->password
            ]
        );
        $_SESSION['timeExpired'] = now()->addMinutes(10);
        return [
            "valid" => $verification->status == "pending",
            "mess" => "OK"
        ];
    }

    /**
     * @return View|Application|Factory|RedirectResponse
     */
    function viewUser(): View|Application|Factory|RedirectResponse
    {
        $inforUser = Session::get('inforUser');
        if ($inforUser) {
            $announceCount = self::checkAnnounceCount();
            return view('seeker.notification.view-user')->with(["dataUser" => $inforUser])->with(
                ['announceCount' => $announceCount]
            );
        } else {
            return Redirect::to('/');
        }
    }

    /**
     * @return int|mixed
     */
    function checkAnnounceCount(): mixed
    {
        $data = self::getAnnounceContent();

        $count = 0;
        foreach ($data as $subData) {
            if ($subData->read_at == "null") {
                $count = $count + 1;
            }
        }
        // dd($count);
        return $count;
    }

    /**
     * @param Request $request
     * @return array
     */
    function loginUser(Request $request): array
    {
//        $this->validate($request, [
//            'sms_number' => 'required|regex:/^([0-9\s\+\(\)]*)$/|min:10'
//        ]);
        $dataUser = self::getDataAccount_CaseLogin($request->sms_number, $request->password);

        $mess = "Successfully Login ";
        if (isset($dataUser)) {
            $convertedArrayDataUser = json_decode(json_encode($dataUser), true);
            $convertedArrayDataUser['id'] = $dataUser->id;
            $request->session()->put('inforUser', $convertedArrayDataUser);
        } else {
            $mess = "Wrong Phone Number or Password";
        }
        return [
            'isLogined' => isset($dataUser),
            'mess' => $mess
        ];
    }

    /**
     * @param Request $request
     * @return array
     * @throws ConfigurationException
     * @throws TwilioException
     */
    public function verifySMS(Request $request): array
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $registerSMS = Session::get('register-SMS');
        try {
            $verification_check = $client->verify->v2->services(getenv("TWILIO_VERIFY_SERVICE_ID"))
                ->verificationChecks
                ->create([
                        "to" => $registerSMS['number-SMS'],
                        "code" => $request->code_otp
                    ]
                );

            if ($verification_check->status == "approved") {
                $profile['displayName'] = $registerSMS['displayName'];
                $profile['phone_number'] = trim($registerSMS['number-SMS']);
                // dump($profile);
                $user = DB::table('notification_user_info')
                    ->where(['phone_number' => $request->number_sms])
                    ->first();
                if (isset($user)) {
                    return [
                        "approved" => true,
                        "mess" => "Connected SMS"
                    ];
                } else {
                    $uuid_user_info = Str::uuid()->toString();
                    $uuid_user_setting = Str::uuid()->toString();
                    $time = date('Y/m/d H:i:s');

                    $inforUser = Session::get('inforUser');
                    $user_id = DB::table('notification_user_info')
                        ->insertGetId([
                            'id' => $uuid_user_info,
                            'phone_number' => $registerSMS['number-SMS'],
                            'password' => $registerSMS['password'],
                            'displayName' => $registerSMS['displayName']
                        ]);
                    $result_inserted = DB::table('notification_user_settings')->insertGetId([
                        'id' => $uuid_user_setting,
                        'user_id' => $uuid_user_info,
                        'notification_channel_id' => UserController::CHANNEL_SMS,
                        'address' => $registerSMS['number-SMS'],
                        'created_at' => $time
                    ]);
                    $textNotification = 'Hello ' . $registerSMS['displayName'] . ', click on this link to see notifications about new users.';
                    $titleSubject = "Notification";
                    DB::table('notification')->insert(
                        [
                            'type' => self::NOTIFICATION_NEW_REGISTER,
                            'announce_title' => $titleSubject,
                            'announce_content' => $textNotification,
                            'created_at' => date('Y/m/d H:i:s'),
                            'is_sent' => true,
                            'is_scheduled' => false,
                            'scheduled_at' => null
                        ]
                    );
                    event(
                        new NewStoreRequestRegistration(
                            self::CHANNEL_SMS,
                            $registerSMS['number-SMS'],
                            "",
                            $textNotification
                        )
                    );
                }

                if (!isset($_SESSION)) {
                    session_start();
                }
                if (isset($_SESSION['timeExpired'])) {
                    unset($_SESSION['timeExpired']);
                }
                return [
                    "approved" => $verification_check->status == "approved",
                    "mess" => "Connected SMS"
                ];
            } else {
                return [
                    "approved" => $verification_check->status == "approved",
                    "mess" => "Wrong Code OTP"
                ];
            }
        } catch (RestException $th) {
            return [
                "expired" => true,
                "mess" => "Code OTP expired"
            ];
        }
    }

    /**
     * @param string $phone_number
     * @param string $password
     * @return Model|Builder|null
     */
    function getDataAccount_CaseLogin(string $phone_number, string $password): Model|Builder|null
    {
        $dataAccount = DB::table('notification_user_info')
            ->where([
                'phone_number' => $phone_number,
                'password' => $password
            ])
            ->first();
        if (isset($dataAccount)) {
            $dataUserSetting = DB::table('notification_user_settings')->
            where([
                'user_id' => $dataAccount->id,
            ])->get([
                'address'
            ])->first();
            $dataAccount->address = $dataUserSetting->address;
        }

        return $dataAccount;
    }


}
