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

    public function index(Request $request) {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            // return Redirect::to('/dashboard');
            $authUrl = $this->lineService->getLoginBaseUrl();
            $authGmail = 'authorized/google';
            $announceCount = UserController::checkAnnounceCount();
            // dd($inforUser);    
            return view('Frontend.home-user',compact(['authUrl','authGmail']))->with(["dataUser" => $inforUser])->with(['announceCount' => $announceCount]);
        }else{
            
            return view('Frontend.login-user');
        }
    }
    public function viewLoginUser()
    {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            return Redirect::to('/user');            
        }else{
            return view('Frontend.login-user');
        }
        
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
    function viewSignupUser()
    {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            return Redirect::to('/user');            
        }else{
            return view('Frontend.signup-user');
        }
        
    }
    
    function viewUser() {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            $announceCount = UserController::checkAnnounceCount();
            $data_setting = DB::table('notification_user_settings')->where(['user_id' =>  $inforUser['userId']])->first();
            // dd($inforUser);
            if(isset($data_setting))
            {

                $inforUser['notification_channel_id'] = $data_setting->notification_channel_id;
                $inforUser['id'] = $data_setting->id;
            }
            
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
    public function viewSettingNotification()
    {
        $authUrl = $this->lineService->getLoginBaseUrl();
        $authGmail = 'authorized/google';
        return view('Frontend.setting-connect-user',compact(['authUrl','authGmail']));
        
    }
    public function connectSMS(Request $request)
    {
        $validated = $this->validate($request,[
            'number_sms'=>'required|regex:/^([0-9\s\+\(\)]*)$/|min:10'
        ]);
        $number_sms_nospace = str_replace(' ','',$request->number_sms);
        $user = DB::table('notification_user_info')
        ->where(['phone_number'=>$number_sms_nospace])
        ->first();
        if(isset($user))
        {
            return ["SMSExisted"=>isset($user),'mess'=>"SMS Number used"];
        }
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        try {
            $verification = $client->verify->v2->services(getenv("TWILIO_VERIFY_SERVICE_ID"))
            ->verifications
            ->create($number_sms_nospace, "sms");
        } catch (RestException $th) {
            return [
                "valid"=>false,
                "mess"=>"SMS Number Invalid"
            ];
        }
        $request->session()->put('register-SMS'
        ,['number-SMS'=>$number_sms_nospace,
          'displayName'=>$request->displayName,
          'password'=>$request->password]);  
        $_SESSION['timeExpired']=now()->addMinutes(10);
        // return [
        //     "valid"=>true,
        //     "mess"=>"OK"
        // ];
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

        $user = DB::table('notification_user_settings')
        ->where(['user_id'=>$request->number_sms,'notification_channel_id'=>UserController::CHANNEL_SMS])
        ->first();
        if(isset($user))
        {

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
                $profile['displayName'] = $registerSMS['displayName'];
                $profile['phone_number'] = trim($registerSMS['number-SMS']);
                // dump($profile);
                $user = DB::table('notification_user_info')
                ->where(['phone_number'=>$request->number_sms])
                ->first();
                if(isset($user))
                {
                    return [
                        "approved"=>true,
                        "mess"=>"Connected SMS"
                    ];
                }
                else
                {
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    date_default_timezone_get();
                    $uuid_user_info = Str::uuid()->toString();
                    $uuid_user_setting = Str::uuid()->toString();
                    $time = date('Y/m/d H:i:s');
                    $inforUser = Session::get('inforUser');
                    $user_id = DB::table('notification_user_info')
                    ->insertGetId([
                              'id'=>$uuid_user_info,  
                              'phone_number'=>$registerSMS['number-SMS'],
                              'password'=>$registerSMS['password'],
                              'displayName'=>$registerSMS['displayName']]);
                    $result_inserted = DB::table('notification_user_settings')->insertGetId([
                        'id'=>$uuid_user_setting,
                        'user_id' => $uuid_user_info,
                        'notification_channel_id' => UserController::CHANNEL_SMS,
                        'address'=>$registerSMS['number-SMS'],
                        'created_at' => $time
                    ]);
                    $textNotification = 'Hello '. $registerSMS['displayName'] .', click on this link to see notifications about new users.';
                    NotificationController::sendMessTwilio($registerSMS['number-SMS'],$textNotification );
                }
                
                if(!isset($_SESSION)) 
                { 
                    session_start(); 
                }
                if(isset($_SESSION['timeExpired']))
                {
                    unset($_SESSION['timeExpired']);
                }
                return [
                    "approved"=>$verification_check->status=="approved",
                    "mess"=>"Connected SMS"
                ];
                // return [
                //     "approved"=>true,
                //     "mess"=>"Connected SMS"
                // ];
                
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
    }

    public function handleLineCallback(Request $request) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        date_default_timezone_get();
        $code = $request->input('code', '');
        $inforUser = Session::get('inforUser');
        $response = $this->lineService->getLineToken($code);
        // Get profile from ID token
        $profile1 = $this->lineService->verifyIDToken($response['id_token']);
        // Get profile from access token.
        $profile = $this->lineService->getUserProfile($response['access_token']);
        $profile['email'] = $profile1['email'];
        $count = DB::table('notification_user_settings')->where(['user_id' =>  $inforUser['userId'],'notification_channel_id' => UserController::CHANNEL_LINE])->get();
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
                'user_id' => $inforUser['userId'],
                'notification_channel_id' => UserController::CHANNEL_LINE,
                'created_at' => $time
            ]);

            $result_inserted = DB::table('notification_user_line')->insertGetId([
                'user_id'=>$inforUser['userId'],
                'user_id_line' => $profile['userId'],
            ]);
        }
        


        return Redirect::to('/user');
    }



 

    function logoutUser() {
        Session::forget('inforUser');
        return Redirect::to('/');
    }

    function loginUser(Request $request)
    {
        $dataUser = UserController::getDataAccount_CaseLogin($request->sms_number,$request->password);
        // dd($request->username,$request->password);
        $mess="Successfully Login ";
        if(isset($dataUser))
        {
            
            $convertedArrayDataUser = json_decode(json_encode($dataUser),true);
            $convertedArrayDataUser['userId'] = $dataUser->id;
            $request->session()->put('inforUser',$convertedArrayDataUser );
        }
        else
        {
            $mess = "Wrong Username or Password";
        }
        return ['isLogined'=>isset($dataUser),
                'mess'=>$mess];
    }
    function signupUser(Request $request)
    {


        return UserController::connectSMS($request);
    
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
    function getDataAccount_CaseLogin($phone_number,$password)
    {
        $dataAccount = DB::table('notification_user_info')
        ->where(['phone_number'=>$phone_number,
                 'password'=>$password])
        ->first();
        return $dataAccount;
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
        // dd($inforUser);
        if($inforUser){
            $dataUser = DB::table('notification_user_settings')
            ->where('user_id', $inforUser['userId'])
            ->first();
            $dateStart = DB::table('notification_user_settings')->where(['user_id' => $inforUser['userId']])->get();
     
            $data=[];
            if(isset($dataUser)&&$dataUser->notification_channel_id==UserController::CHANNEL_EMAIL && count($dateStart)>0)
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
            else if(isset($dataUser)&&count($dateStart)>0)
            {
                // dump($dateStart,$inforUser);
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
            else if(!isset($dataUser))
            {
                return [];
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
