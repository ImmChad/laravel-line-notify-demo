<?php

namespace App\Http\Controllers\User;

use App\Services\LineService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

use Illuminate\Support\Facades\DB;

// use Illuminate\View\View;
// use Symfony\Component\HttpFoundation\RedirectResponse;
// use Carbon\Carbon;
// use Laravel\Socialite\Facades\Socialite;


use LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
// use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;
use stdClass;
use Illuminate\Support\Str;
use App\Http\Controllers\Admin\NotificationController;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;        
session_start();
class UserController extends Controller
{

    protected $lineService;
    const CHANNEL_LINE = 1;
    const CHANNEL_EMAIL = 2;
    const CHANNEL_SMS = 3;
    public function __construct(LineService $lineService)
    {
        $this->lineService = $lineService;
    }
    public function viewConnectSMS()
    {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            return Redirect::to('/user');            
        }else{
            return view('Frontend.view-register-sms');
        }

    }
    public function viewLoginSMS()
    {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            return Redirect::to('/user');            
        }else{
            return view('Frontend.view-login-sms');
        }
    }
    public function index(Request $request) {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            // return Redirect::to('/dashboard');
            $announceCount = UserController::checkAnnounceCount();
            
            return view('Frontend.view-user')->with(["dataUser" => $inforUser])->with(['announceCount' => $announceCount]);
        }else{
            $authUrl = $this->lineService->getLoginBaseUrl();
            $authGmail = 'authorized/google';
            return view('Frontend.login-user', compact(['authUrl','authGmail']));
        }
    }
    public function connectSMS(Request $request)
    {
        $validated = $this->validate($request,[
            'number_sms'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
        ]);

        $user = DB::table('notification_user_info')
        ->where('user_id',$request->number_sms)
        ->first();
        if(isset($user))
        {
            $profile['displayName'] = $user->displayName;
            $profile['userId'] = $user->user_id;
            $profile['pictureUrl'] = null;
            $profile['email'] = null;
            $profile['phone_number'] = $user->phone_number;

            $request->session()->put('inforUser', $profile);
            return ["logged_in"=>isset($user)];
        }

        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        try {
            $verification = $client->verify->v2->services(getenv("TWILIO_VERIFY_SERVICE_ID"))
            ->verifications
            ->create($request->number_sms, "sms");
        } catch (RestException $th) {
            return [
                "valid"=>false,
                "mess"=>"Number SMS Invalid"
            ];
        }
        $request->session()->put('register-SMS'
        ,['number-SMS'=>$request->number_sms,
          'user-name'=>$request->name_user]);
        $_SESSION['timeExpired']=now()->addMinutes(10);
        return [
            "valid"=>$verification->status=="pending",
            "mess"=>"OK"
        ];

    }
    public function loginSMS(Request $request)
    {

        $validated = $this->validate($request,[
            'number_sms'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
        ]);

        $user = DB::table('notification_user_info')
        ->where('user_id',$request->number_sms)
        ->first();
        if(isset($user))
        {
            $profile['displayName'] = $user->displayName;
            $profile['userId'] = $user->user_id;
            $profile['pictureUrl'] = null;
            $profile['email'] = null;
            $profile['phone_number'] = $user->phone_number;
            $request->session()->put('inforUser', $profile);
            return ["logged_in"=>isset($user)];

        }
        $_SESSION['toast']="Number phone don't use service,Connect now!!!";
         return [
            "logged_in"=>isset($user),
            "mess"=>"Number phone don't use service"
        ];
    }
    public function  verifySMS(Request $request)
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
            if($verification_check->status=="approved")
            {
                $profile['displayName'] = $registerSMS['user-name'];
                $profile['userId'] = $registerSMS['number-SMS'];
                $profile['pictureUrl'] = null;
                $profile['email'] = null;
                $profile['phone_number'] = trim($registerSMS['number-SMS']);
                $request->session()->put('inforUser', $profile);
                // dump($profile);
                $user = DB::table('notification_user_info')
                ->where('user_id',$request->number_sms)
                ->first();
                if(isset($user))
                {

                }
                else
                {
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    date_default_timezone_get();
                    $uuid = Str::uuid()->toString();
                    $time = date('Y/m/d H:i:s');
                    $result_inserted = DB::table('notification_user_settings')->insertGetId([
                        'id'=>$uuid,
                        'user_id' => $profile['userId'],
                        'notification_channel_id' => UserController::CHANNEL_SMS,
                        'created_at' => $time
                    ]);
                    
                    $data = DB::table('notification_user_info')->insertGetId([
                        'id'=>$uuid,
                        'user_id' => $profile['userId'],
                        'displayName' => $profile['displayName'],
                        'pictureUrl' => $profile['pictureUrl'],
                        'email' => $profile['email'],
                        'phone_number' => $profile['phone_number']
                    ]); 
                    $textNotification = 'Hello '. $profile['displayName'] .', click on this link to see notifications about new users.';
                    NotificationController::sendMessTwilio($profile['phone_number'],$textNotification );
                }

                return [
                    "approved"=>$verification_check->status=="approved",
                    "mess"=>"Connected SMS"
                ];
            }
            else
            {
                return [
                    "approved"=>$verification_check->status=="approved",
                    "mess"=>"Wrong Code OTP"
                ];
            }    
        } catch (RestException $th) {
            return [
                "expired"=>true,
                "mess"=>"Code OTP expired"
            ];
        }
        return Redirect::to('/user/connect-sms');
    }

    public function handleLineCallback(Request $request) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        date_default_timezone_get();
        $code = $request->input('code', '');
        $response = $this->lineService->getLineToken($code);
        
        // dump(json_decode($body)->access_token);
        // dd(json_decode($body)->id_token);


        // Get profile from ID token
        $profile1 = $this->lineService->verifyIDToken($response['id_token']);
        
        // dump($profile);
        
        // $profile = $this->lineService->verifyIDToken($response['id_token']);
        
        // Get profile from access token.
        $profile = $this->lineService->getUserProfile($response['access_token']);
        $profile['email'] = $profile1['email'];
        // dd($profile);

        // return view('Frontend.view-user')->with(["dataUser" => $profile]);
        $request->session()->put('inforUser', $profile);


        $dataUpdate = DB::table('notification_user_info')
        ->where(['user_id' =>  $profile['userId']])
        ->update([
            'user_id' => $profile['userId'],
            'displayName' => $profile['displayName'],
            'pictureUrl' => $profile['pictureUrl'],
            'email' => $profile['email']
        ]);

        $count = DB::table('notification_user_info')->where(['user_id' =>  $profile['userId']])->get();
        if(count($count) == 0) {
            if(!isset($profile['pictureUrl'])) {
                $profile['pictureUrl'] = "";
            }
            if(!isset($profile['email'])) {
                $profile['email'] = "";
            }

            UserController::sendMessForUser($profile['userId'], $profile['displayName']);
            $uuid = Str::uuid()->toString();
            $time = date('Y/m/d H:i:s');
            $result_inserted = DB::table('notification_user_settings')->insertGetId([
                'id'=>$uuid,
                'user_id' => $profile['userId'],
                'notification_channel_id' => UserController::CHANNEL_LINE,
                'created_at' => $time
            ]);

            $result_inserted = DB::table('notification_user_line')->insertGetId([
                'user_id'=>$uuid,
                'user_id_line' => $profile['userId'],
            ]);
            
            $data = DB::table('notification_user_info')->insertGetId([
                'id'=>$uuid,
                'user_id' => $profile['userId'],
                'displayName' => $profile['displayName'],
                'pictureUrl' => $profile['pictureUrl'],
                'email' => $profile['email']
            ]);


            

            
        }
        


        return Redirect::to('/user');
    }

    function viewUser() {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            $announceCount = UserController::checkAnnounceCount();
            $data_setting = DB::table('notification_user_settings')->where(['user_id' =>  $inforUser['userId']])->first();
            // dd($inforUser);
            $inforUser['notification_channel_id'] = $data_setting->notification_channel_id;
            $inforUser['id'] = $data_setting->id;
            
            return view('Frontend.view-user')->with(["dataUser" => $inforUser])->with(['announceCount' => $announceCount]);
        }else{
            return Redirect::to('/');
        }
    }

    function viewAllAnnounceUser() {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            // return Redirect::to('/dashboard');


            $dataList = UserController::getAnnounceContent();
            // dump($dataList);
            return view('Frontend.view-announce-user')->with(["dataList" => $dataList]);
        }else{
            return Redirect::to('/');
        }
    }

    function logoutUser() {
        Session::forget('inforUser');
        return Redirect::to('/');
    }

    function sendMessForUser($userId, $displayName) {

        // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('<channel access token>');
        // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '<channel secret>']);
        // $userIds = [$userId];
        // $bot->multicast($userIds, '<message>');

        $httpClient = new CurlHTTPClient(env('LINE_BOT_CHANNEL_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_BOT_CHANNEL_SECRET')]);

        // $responseUser = $bot->getProfile($userId);


        $userIds = $userId;
        $message = new TextMessageBuilder('Hello '.$displayName.', click on this link to see notifications about new users.');
        $bot->pushMessage($userIds, $message);

        

        return $message;
    }

    function getAnnounceContentRead(Request $request) {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            

            $countUpdate = DB::table('tb_announce_read')
            ->where(['notification_id' => $request->id])
            ->where(['user_id' => $inforUser['userId']])
            ->get();
            if(count($countUpdate) == 0) {
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                date_default_timezone_get();
                $dataUpdate = DB::table('tb_announce_read')
                ->insert([
                    'notification_id' => $request->id,
                    'userId' => $inforUser['userId'],
                    'read_at' => date('Y/m/d H:i:s')
                ]);
            }
            


            $notifications = DB::table('notification')
            ->where(['id' => $request->id])

            ->get(
                array(
                    'id',
                    'announce_title',
                    'announce_content',
                    'created_at'
                    )
            );
            foreach($notifications as $key=>$notification)
            {
                $type_notification = DB::table('notification_type')
                ->where('id',$notification->type)->first();
                if($type_notification);
                $notifications[$key]->name_type = $type_notification->type;
            }
            return $notifications;
        }else{
            return Redirect::to('/');
        }
        
    }


    function checkAnnounceCount() {
        $data = UserController::getAnnounceContent();
        
        $count = 0;
        foreach($data as $subData) {
            if($subData->read_at == "null") {
                $count = $count + 1;
            }
        }
        // dd($count);
        return $count;
    }


    function getAnnounceContent() {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            $dataUser = DB::table('notification_user_settings')
            ->where('user_id', $inforUser['userId'])
            ->first();

            $dateStart = DB::table('notification_user_settings')->where(['user_id' => $inforUser['userId']])->get();
            $data=[];
            if($dataUser->notification_channel_id==UserController::CHANNEL_EMAIL)
            {
                
                $data = DB::table('notification')
                ->where('created_at', '>=', $dateStart[0]->created_at)
                ->where('is_sent','!=',null)
                ->where('is_sent','!=',false)
                ->where('type','!=', NotificationController::NOTIFICATION_NEW_REGISTER)
                ->orderByDesc('id')
                ->get(
                    array(
                        'id',
                        'type',
                        'announce_title',
                        'announce_content',
                        'created_at'
                        )
                );
            }
            else
            {
                $data = DB::table('notification')
                ->where('created_at', '>=', $dateStart[0]->created_at)
                ->where('is_sent','!=',null)
                ->where('is_sent','!=',false)
                ->where('type','!=', NotificationController::NOTIFICATION_EMAIL_MAGAZINE)
                ->where('type','!=', NotificationController::NOTIFICATION_NEW_REGISTER)
                ->orderByDesc('id')
                ->get(
                    array(
                        'id',
                        'type',
                        'announce_title',
                        'announce_content',
                        'created_at'
                        )
                );
            }
            
            foreach($data as $key=>$notification)
            {
                $type_notification = DB::table('notification_type')
                ->where('id',$notification->type)->first();
                if($type_notification);
                $data[$key]->name_type = $type_notification->type;
            }
            
            $newData = new stdClass();
            $ListData = [];
            
            foreach($data as $subData) {
                $dataAnnounce=[];
                if($dataUser->notification_channel_id==UserController::CHANNEL_EMAIL)
                {
                    if($subData->id)
                    $dataAnnounce = DB::table('notification_read')
                    ->where(['notification_id' => $subData->id])
                    ->where(['user_id' => $dataUser->id])
                    ->get(
                        array(
                            'read_at'
                            )
                    );
                }
                else
                {
                    if($subData->id && $subData->type != NotificationController::NOTIFICATION_EMAIL_MAGAZINE)
                    $dataAnnounce = DB::table('notification_read')
                    ->where(['notification_id' => $subData->id])
                    ->where(['user_id' => $dataUser->id])
                    ->where(['user_id' => $dataUser->id])
                    ->get(
                        array(
                            'read_at'
                            )
                    ); 
                }

                if(count($dataAnnounce) > 0) {
                    $subData->read_at = $dataAnnounce[0]->read_at;
                } else {
                    $subData->read_at = "null";
                }
                $ListData[count($ListData)] = $subData;
            }
            $newData = $ListData;
            // dd($newData);
            return $newData;
        }else{
            return Redirect::to('/');
        }
        
    }
    function detailNotification(Request $request,$id)
    {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            $dataUser = DB::table('notification_user_settings')
            ->where('user_id',$inforUser['userId'])
            ->first();
            $notification = null;
            if($dataUser->notification_channel_id==UserController::CHANNEL_EMAIL)
            {
                $notification = DB::table('notification')
                ->where(['id' => $id])
                ->first();
            }
            else
            {
                $notification = DB::table('notification')
                ->where(['id' => $id])
                ->where('type','!=',NotificationController::NOTIFICATION_EMAIL_MAGAZINE)
                ->first();
            }
            if($notification)
            {
                if($dataUser)
                {
                    $count = DB::table('notification_read')
                    ->where(['notification_id'=>$notification->id,
                              'user_id'=>$dataUser->id,
                    ])->get();
                    if(count($count)==0)
                    {
                        $insert = DB::table('notification_read')
                        ->insert(['notification_id'=>$notification->id,
                                  'user_id'=>$dataUser->id,
                                  'read_at'=>now()
                    ]);
                    }
                }
                $type_notification = DB::table('notification_type')
                ->where('id',$notification->type)->first();
                if($type_notification);
                $notification->name_type = $type_notification->type;
                // dump($notification);
                return view("Frontend.view-announce-user-detail")->with(['notification'=>$notification]);
            }
            else
            {
                return Redirect::to('/');
            }
            
        }
        else{
            return Redirect::to('/');
        }

    }
}
