<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\NotificationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Exception;
use Socialite;
use Mail;
use Session;

class ConnectGmailController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {      
            $user = Socialite::driver('google')->stateless()->user();
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            date_default_timezone_get();    
            $inforUser = Session::get('inforUser');
            $count = DB::table('notification_user_settings')->where(['user_id' =>  $inforUser['userId'],'notification_channel_id'=>UserController::CHANNEL_EMAIL])->get();
            if(count($count)==0)
            {
                $uuid = Str::uuid()->toString();
                $resultInsert= DB::table('notification_user_settings')->
                insert([
                    'id'=> $uuid,
                    'user_id'=>$inforUser['userId'],
                    'notification_channel_id'=>UserController::CHANNEL_EMAIL,
                    'created_at'=>date('Y/m/d H:i:s'),
                ]);
                $resultUpdate_user_info = DB::table('notification_user_info')->
                where([
                    'id'=>$inforUser['userId'],
                ])->update([
                    'email'=>$user->email
                ]);
                $inforUser['email']=$user->email;
                $request->session()->put('inforUser', $inforUser);
                $email = $user->email;
                $displayName = $user->name;
                $textNotification = 'Hello '. $displayName .', click on this link to see notifications about new users.';
                $titleSubject = "Notification";
                Mail::send([],[], function ($message) use ($email,$titleSubject, $textNotification) {
                    $message->from(env('MAIL_FROM_ADDRESS'), 'Notification Web');
                    $message->to($email);
                    $message->subject($titleSubject);
                    $message->html($textNotification); // tôi muốn truyền mess vô? tham số mô? 
                });

                DB::table('notification')->insert(
                    ['type'=>NotificationController::NOTIFICATION_NEW_REGISTER,
                     'announce_title'=>$titleSubject,
                     'announce_content'=>$textNotification,
                     'created_at'=>date('Y/m/d H:i:s'),
                     'is_sent'=>true,
                     'is_scheduled'=>false,
                     'scheduled_at'=>null   
                     ]
                );
            }            
        return Redirect::to('/user');
    }

}
