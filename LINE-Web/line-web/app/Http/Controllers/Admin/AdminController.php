<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\DoSomethingJob;
use App\Jobs\SendGmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Session;
use stdClass;
use Twilio\Rest\Client;
use App\Mail\NotificationMail;
use App\Notifications\NotificationMessage;
use Illuminate\Support\Facades\Notification;

// use Illuminate\Notifications\Notification;

class AdminController extends Controller
{
    function optionNavigationView() {
        return view('Backend.navigation-view');
    }

    function announceView() {
        $dataList = AdminController::listAnnounce();
        return view('Backend.view-announce')->with(['dataList' => $dataList]);
    }

    function sendMessView() {
        return view('Backend.view-send-mess');
    }


    function index() {

        $dataList = AdminController::listConnectLine();
        // dd($dataList);

        return view('Backend.view-admin')->with(["dataList" => $dataList]);
    }

    

    function sendMessForListUser(Request $request) {

        $userIds = AdminController::listConnectAll();

        // $user = User::find($id);
        // $user->notify(new MyMultiChannelNotification($message, $user->line_id));

    

        $param = $request->message;
        // $userId = $subUserId->userId;
        // $emailTo = $subUserId->email;


        DoSomethingJob::dispatch($param)->delay(now()->addSeconds(intval($request->delayTime)));
        SendGmail::dispatch($request->message)->delay(now()->addSeconds(intval($request->delayTime)));
        $this->SMS_sendNotification($request);



        // dump($userGmail);
        // dd($userLine);




        // foreach($userIds as $subUserId) {
        //     $status = DB::table('tb_connect_line')->where(['userId' =>  $subUserId->userId])->get()[0]->status;
        //     if($status == "connect to line") {
        //         $param = $request->message;
        //         $userId = $subUserId->userId;
        //         $doJob = DoSomethingJob::dispatch($param, $userId)->delay(now()->addSeconds(intval($request->delayTime)));
                
        //     } 
        //     else if($status == "connect to gmail")
        //     {
        //         $emailTo = $subUserId->email;

        //         SendGmail::dispatch($emailTo, $request->message)->delay(now()->addSeconds(intval($request->delayTime)));

        //         $this->SMS_sendNotification($request);
        //         // Mail::to($request->email)->send(new NotificationMail($mailData));
        //     }
        // }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        date_default_timezone_get();
        $data2 = DB::table('tb_announce')->insertGetId([
            'announce_title' => $request->title,
            'announce_content' => $request->message,
            'created_at' => date('Y/m/d H:i:s')
        ]);





        $userIds = $request->delayTime;
        return $userIds;
    }


    function SMS_sendNotification(Request $request)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");

        $client = new Client($account_sid, $auth_token);
        // Teacher number
        $client->messages->create("+84 91 664 91 09", ['from' => $twilio_number, 'body' => $request->message]);
        // Dung number
        // $client->messages->create("+84 339 601 517", ['from' => $twilio_number, 'body' => $request->message]);

        // $validation_request = 
        //     $client->validationRequests
        //         ->create("+84354723814", // phoneNumber
        //                 ["friendlyName" => "VKU TUNG TRUONG"]
        //         );
        // dump($validation_request);
    }

    function getAnnounceContent(Request $request) {
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
    }

    public static function listConnectLine() {
        $data = DB::table('tb_connect_line')
        ->where(['status' => "connect to line"])
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

    public static function listConnectAll() {
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

    function listAnnounce() {
        $data = DB::table('tb_announce')
        ->orderByDesc('id')
        ->get(
            array(
                'id',
                'announce_title',
                'announce_content',
                'created_at'
                )
        );

        return $data;
    }

    public static function listUser($status) {
        $data = DB::table('tb_connect_line')
        ->where(['status' => $status])
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
}
