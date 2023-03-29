<?php

namespace App\Handler;

use App\Events\NewStoreRequestRegistration;
use App\Http\Controllers\User\UserController;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Session;
class UserHandler
{
    public function __construct(private readonly UserRepository $userRepository,
                                private readonly NotificationRepository $notificationRepository)
    {
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        $user = Socialite::driver('google')->stateless()->user();
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $inforUser = Session::get('inforUser');

        $this->userRepository->updateNotificationUserInfo($inforUser['userId'], [
            'pictureUrl'=>$user->avatar
        ]);

        $this->userRepository->updateNotificationUserSetting($inforUser['userId'], [
            'address'=>$user->email,
            'notification_channel_id'=>UserController::CHANNEL_EMAIL,
            'updated_at'=>date('Y/m/d H:i:s'),
        ]);

        $inforUser['address']=$user->email;
        $inforUser['pictureUrl']=$user->avatar;
        $request->session()->put('inforUser', $inforUser);

        $email = $user->email;
        $displayName = $user->name;
        $textNotification = 'Hello '. $displayName .', click on this link to see notifications about new users.';
        $titleSubject = "Notification";
        event(new NewStoreRequestRegistration(UserController::CHANNEL_EMAIL, $email, $titleSubject, $textNotification));

        $this->notificationRepository->insertNotificationNewStoreRegistration(
            ['type'=> 1,
                'announce_title'=>$titleSubject,
                'announce_content'=>$textNotification,
                'created_at'=>date('Y/m/d H:i:s'),
                'is_sent'=>true,
                'is_scheduled'=>false,
                'scheduled_at'=>null
            ]
        );
        return Redirect::to('/user');
    }
}
