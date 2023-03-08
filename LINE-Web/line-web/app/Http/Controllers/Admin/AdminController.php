<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Session;
use stdClass;

class AdminController extends Controller
{
    function index() {

        $dataList = AdminController::listConnectLine();
        // dd($dataList);

        return view('Backend.view-admin')->with(["dataList" => $dataList]);
    }

    function listConnectLine() {
        $data = DB::table('tb_connect_line')
        ->get(
            array(
                'id',
                'userId',
                'status',
                'date'
                )
        );



        $newListData = new stdClass();
        $List = [];
        foreach($data as $subData) {
            $displayName = DB::table('tb_user_info')->where(['userId' =>  $subData->userId])->get()[0]->displayName;
            $email = DB::table('tb_user_info')->where(['userId' =>  $subData->userId])->get()[0]->email;

            $subData->displayName = $displayName;
            $subData->email = $email;

            $List[count($List)] = $subData;
        }
        $newListData = $List;


        return $newListData;
    }

    function sendMessForListUser(Request $request) {
        // dump(json_decode($request->listUserId));
        // dd($request->message);
        // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('<channel access token>');
        // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '<channel secret>']);
        // $userIds = [$userId];
        // $bot->multicast($userIds, '<message>');

        $httpClient = new CurlHTTPClient(env('LINE_BOT_CHANNEL_TOKEN'));
        $bot = new LINEBot($httpClient, ['channelSecret' => env('LINE_BOT_CHANNEL_SECRET')]);
        
        // $responseUser = $bot->getProfile($userId);

        $userIds = json_decode($request->listUserId);
        foreach($userIds as $subUserId) {
            $message = new TextMessageBuilder($request->message);
            $bot->pushMessage($subUserId, $message);
        }
        
        return $userIds;
    }
}
