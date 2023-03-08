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
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    protected $lineService;

    public function __construct(LineService $lineService)
    {
        $this->lineService = $lineService;
    }

    public function index(Request $request) {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            // return Redirect::to('/dashboard');
            return view('Frontend.view-user')->with(["dataUser" => $inforUser]);
        }else{
            $authUrl = $this->lineService->getLoginBaseUrl();
    
            return view('Frontend.login-user', compact('authUrl'));
        }
    }

    public function handleLineCallback(Request $request) {
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

        UserController::sendMessForUser($profile['userId']);
        // return view('Frontend.view-user')->with(["dataUser" => $profile]);
        $request->session()->put('inforUser', $profile);

        $dataUpdate = DB::table('tb_user_info')
        ->where(['userId' =>  $profile['userId']])
        ->update([
            'userId' => $profile['userId'],
            'displayName' => $profile['displayName'],
            'pictureUrl' => $profile['pictureUrl'],
            'email' => $profile['email']
        ]);

        $count = DB::table('tb_user_info')->where(['userId' =>  $profile['userId']])->get();
        if(count($count) == 0) {
            if(!isset($profile['pictureUrl'])) {
                $profile['pictureUrl'] = "";
            }
            if(!isset($profile['email'])) {
                $profile['email'] = "";
            }

            $data = DB::table('tb_user_info')->insertGetId([
                'userId' => $profile['userId'],
                'displayName' => $profile['displayName'],
                'pictureUrl' => $profile['pictureUrl'],
                'email' => $profile['email']
            ]);

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            date_default_timezone_get();
            $data2 = DB::table('tb_connect_line')->insertGetId([
                'userId' => $profile['userId'],
                'status' => "has login",
                'date' => date('Y/m/d H:i:s')
            ]);
            
        }
        


        return Redirect::to('/user');
    }

    function viewUser() {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            // return Redirect::to('/dashboard');
            return view('Frontend.view-user')->with(["dataUser" => $inforUser]);
        }else{
            return Redirect::to('/');
        }
    }

    function logoutUser() {
        Session::forget('inforUser');
        return Redirect::to('/');
    }

    function sendMessForUser($userId) {

        // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('<channel access token>');
        // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '<channel secret>']);
        // $userIds = [$userId];
        // $bot->multicast($userIds, '<message>');

        $httpClient = new CurlHTTPClient(env('LINE_BOT_CHANNEL_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_BOT_CHANNEL_SECRET')]);

        // $responseUser = $bot->getProfile($userId);


        $userIds = $userId;
        $message = new TextMessageBuilder('Hello, welcome to our app of TUNG DUNG!');
        $bot->pushMessage($userIds, $message);

        


        return $message;
    }


    // public function getLineChannelInfo()
    // {
    //     $httpClient = new Client();
    //     $response = $httpClient->get("https://api.line.me/v2/bot/channel/" .env('LINE_LOGIN_CHANNEL_ID'). "/info", [
    //         'headers' => [
    //             'Authorization' => 'Bearer ' . LINE_LOGIN_CHANNEL_ACCESS_TOKEN,
    //             'Content-Type' => 'application/json'
    //         ]
    //     ]);
    //     $body = json_decode($response->getBody(), true);
    //     $channelId = $body['channelId'];
    //     $channelName = $body['channelName'];
    //     $channelIcon = $body['channelIcon'];
    //     return view('your-view', compact('channelId', 'channelName', 'channelIcon'));
    // }



}
