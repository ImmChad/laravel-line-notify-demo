<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Mail;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\NotificationController;
use Illuminate\Support\Str;
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
            $count = DB::table('notification_user_info')->where(['user_id' =>  $user['id']])->get();
            if(count($count)==0)
            {
                $uuid = Str::uuid()->toString();
                $resultInsert= DB::table('notification_user_settings')->
                insert([
                    'id'=> $uuid,
                    'user_id'=>$user->id,
                    'notification_channel_id'=>UserController::CHANNEL_EMAIL,
                    'created_at'=>date('Y/m/d H:i:s'),
                ]);
                
                $resultInsert_user_info = DB::table('notification_user_info')->
                insert([
                    'id'=>$uuid,
                    'user_id'=>$user->id,
                    'displayName'=>$user->name,
                    'pictureUrl'=>$user->avatar,
                    'email'=>$user->email
                ]);

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
            else
            {
                $dataUpdateGmail = DB::table('notification_user_info')
                ->where(['user_id' =>  $user['id']])
                ->update([
                    'displayName'=>$user->name,
                    'pictureUrl'=>$user->avatar,
                    'email'=>$user->email
                ]);
            }
            $profile = DB::table('notification_user_info')->where(['user_id' =>  $user['id']])->get()[0];
            $profile->userId =$profile->user_id;
            $profile= json_decode(json_encode($profile), true);
            $request->session()->put('inforUser', $profile);              
        return Redirect::to('/user');
    }

}
