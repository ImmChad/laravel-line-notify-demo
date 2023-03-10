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
use stdClass;

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
            $authGmail = 'authorized/google';
            return view('Frontend.login-user', compact(['authUrl','authGmail']));
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

            UserController::sendMessForUser($profile['userId'], $profile['displayName']);

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
                'status' => "connect to line",
                'date' => date('Y/m/d H:i:s')
            ]);
            
        }
        


        return Redirect::to('/user');
    }

    function viewUser() {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            
            
            $announceCount = UserController::checkAnnounceCount();
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
            ->where(['userId' => $inforUser['userId']])
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


            $data = DB::table('tb_announce')
            ->where(['id' => $request->id])
            ->get(
                array(
                    'id',
                    'announce_title',
                    'announce_content',
                    'created_at'
                    )
            );

            return $data;
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
        return $count;
    }


    function getAnnounceContent() {
        $inforUser = Session::get('inforUser');
        if($inforUser){
            $data = DB::table('tb_announce')
            ->get(
                array(
                    'id',
                    'announce_title',
                    'announce_content',
                    'created_at'
                    )
            );

            $newData = new stdClass();
            $ListData = [];
            foreach($data as $subData) {
                $dataAnnounce = DB::table('tb_announce_read')
                ->where(['notification_id' => $subData->id])
                ->where(['userId' => $inforUser['userId']])
                ->get(
                    array(
                        'read_at'
                        )
                );
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
}
