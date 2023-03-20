<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use App\Jobs\SendLine;
use App\Jobs\SendSMS;

use App\Events\NewNotificationFromAdminEvent;
use App\Events\NewEmailMagazineEvent;

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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use App\Http\Controllers\User\UserController;
use DOMDocument;


// use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
    const NOTIFICATION_NEW_REGISTER = 1;
    const NOTIFICATION_FROM_ADMIN = 2;
    const NOTIFICATION_EMAIL_MAGAZINE = 3;
    function loginAdmin()
    {
        $data_admin = Session::get('data_admin');
        if($data_admin)
        {
            return NotificationController::NavigationView();
        }
        else
        {
            return view('Backend.login-admin');
        }
        
    }
    function handleSubmitLogin(Request $request)
    {

            $password = $request->password;
            $username = $request->username;
            $dataAdmin = DB::table('admin')
            ->where(['password'=>$password,
                     'username'=>$username])
            ->get();
            if(count($dataAdmin)==1)
            {
                $request->session()->put('data_admin',$dataAdmin);
                return ['logged_in'=>true];
            }
            else
            {
                // dump('wrong');
                return ['mess'=>"Wrong username or password"];
            }        
    }
    function NavigationView() {
        $dataList = NotificationController::listConnectLine();
        // dump($dataList);

        return Redirect::to('/admin/register-line-list');
    }

    function RegisterLineList() {
        $dataList = NotificationController::listConnectLine();
        
        
        return view('Backend.register-line-list')->with(["dataList" => $dataList]);;
    }
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    function NotificationList(Request $request) {
        $data_admin = Session::get('data_admin');
        if($data_admin)
        {
            $dataList = NotificationController::searchNotification($request);
            // dump($dataList)
            // $dataList = NotificationController::listAnnounce();
            $dataList = $this->paginate($dataList); 
            $dataList->withPath('/admin/notification-list');
            return view('Backend.notification-list')->with(['dataList' => $dataList]);
        }
        else
        {
            return Redirect::to('/admin');
        }
    }

    function SendNotificationView($notification_type) {
        if($notification_type == 2) {
            if(isset($_GET['messToast'])) {
                return view('Backend.send-notification-view-2')->with('messToast', $_GET['messToast']);
            } else {
                return view('Backend.send-notification-view-2');
            }
        } else if($notification_type == 3) {
            $dataTemplate = NotificationController::getTemplate();
            if(isset($_GET['messToast'])) {
                return view('Backend.send-notification-view-3')
                ->with('dataTemplate', $dataTemplate)
                ->with('messToast', $_GET['messToast']);
            } else {


                return view('Backend.send-notification-view-3')
                ->with('dataTemplate', $dataTemplate);
            }
        } else {
            return Redirect::to('/admin/notification-list');
        }
    }








    function sendMessView() {
        return view('Backend.view-send-mess');
    }


    function index() {

        $dataList = NotificationController::listConnectLine();
        // dump($dataList);

        return NotificationController::RegisterLineList()->with(["dataList" => $dataList]);
    }

    

    function sendMessForListUser(Request $request) {

        $userIds = NotificationController::listConnectAll();    
        // dd($request->message,$request->title,$request->delayTime);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        date_default_timezone_get();
        $is_scheduled = $request->delayTime>0;
        $is_sent = false;
        $scheduled_at = $is_scheduled?now()->addSeconds(intval($request->delayTime)):null;
        $new_notification_id = DB::table('notification')->insertGetId([
            'type'=>$request->type_notification,
            'announce_title' => $request->title,
            'announce_content' => $request->message,
            'is_sent'=>true,
            'is_scheduled'=>$is_scheduled,
            'created_at' => date('Y/m/d H:i:s'),
            'scheduled_at'=>$scheduled_at
        ]);
        
        if(intval($request->type_notification )=== NotificationController::NOTIFICATION_EMAIL_MAGAZINE)
        {
            // dd($request->type_notification,$request->scheduled_at);
            event((new NewEmailMagazineEvent($new_notification_id)));
        
        }
        else if (intval($request->type_notification )=== NotificationController::NOTIFICATION_FROM_ADMIN)
        {
            event((new NewNotificationFromAdminEvent($new_notification_id)));
        }
               
        $userIds = $request->delayTime;
        return $userIds;
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
        $data = DB::table('notification_user_settings')
        ->where(['notification_channel_id' =>UserController::CHANNEL_LINE])
        ->get(
            array(
                'id',
                'user_id',
                'notification_channel_id',
                'created_at'
                )
        );

        $newListData = new stdClass();
        $List = [];
        foreach($data as $subData) {
            $displayName = DB::table('notification_user_info')->where(['id' =>  $subData->user_id])->get()[0]->displayName;
            $email = DB::table('notification_user_info')->where(['id' =>  $subData->user_id])->get()[0]->email;

            $subData->displayName = $displayName;
            $subData->email = $email;

            $List[count($List)] = $subData;
        }
        $newListData = $List;


        return $newListData;
    }

    public static function listConnectAll() {
        $data = DB::table('notification_user_settings')
        ->get(
            array(
                'id',
                'user_id',
                'notification_channel_id',
                'created_at'
                )
        );

        $newListData = new stdClass();
        $List = [];
        foreach($data as $subData) {
            $displayName = DB::table('notification_user_info')->where(['id' =>  $subData->user_id])->get()[0]->displayName;
            $email = DB::table('notification_user_info')->where(['id' =>  $subData->user_id])->get()[0]->email;

            $subData->displayName = $displayName;
            $subData->email = $email;

            $List[count($List)] = $subData;
        }
        $newListData = $List;


        return $newListData;
    }

    function listAnnounce() {
        $notifications = DB::table('notification')
        ->orderByDesc('id')
        ->get(
        );
        foreach($notifications as $key=>$notification)
        {
            $type_notification = DB::table('notification_type')
            ->where('id',$notification->type)->first();
            if($type_notification);
            $notifications[$key]->name_type = $type_notification->type;
        }

        return $notifications;
    }

    public static function listUser($status) {
        $data = DB::table('notification_user_settings')
        ->where(['notification_channel_id' => $status])
        ->get(
            array(
                'id',
                'user_id',
                'notification_channel_id',
                'created_at'
                )
        );

        $newListData = new stdClass();
        $List = [];
        foreach($data as $subData) {
            $dataTmpUser = DB::table('notification_user_info')->where(['id' =>  $subData->user_id])->first();

            $subData->displayName = $dataTmpUser->displayName;
            $subData->email = $dataTmpUser->email;

            $List[count($List)] = $subData;
        }
        $newListData = $List;


        return $newListData;
    }
    function detailNotification(Request $request,$id)
    {
        $dataAdmin = Session::get('data_admin');
        if($dataAdmin){
            $notification = null;
                $notification = DB::table('notification')
                ->where(['id' => $id])
                ->first();
                $type_notification = DB::table('notification_type')
                ->where('id',$notification->type)->first();
                if($type_notification);
                $notification->name_type = $type_notification->type;
                // dump($notification);
                return view("Backend.view-announce-admin-detail")->with(['notification'=>$notification]);
        }
        else{
            return Redirect::to('/');
        }

    }
    public function reqLogout()
    {
        Session::forget('data_admin');
        return Redirect::to('/admin');
    }
    function searchNotification(Request $request)
    {
        $text_search = $request['txt-search-notification'];
        $matched_notifications = 
            DB::table('notification')
            ->orWhere('announce_title','like',"%{$text_search}%")
            // ->orWhere('announce_content','like',"%{$text_search}%")
            // ->orWhere('scheduled_at','like',"%{$text_search}%")
            ->get();
            // dump($matched_notifications);
        // foreach($matched_notifications as $key=>$value){
        //     // $matched_notifications
        //     if(!str_contains($value->announce_title,$text_search)&&$value->type==NotificationController::NOTIFICATION_EMAIL_MAGAZINE)
        //     {
        //         $dom = new DOMDocument();
        //         $dom->loadhtml($value->announce_content);
        //         if(!str_contains($dom->textContent,$text_search))
        //         {
        //             // dump($value->announce_content,$dom->textContent);
        //             unset($matched_notifications[$key]);
        //         }
        //     }

        // }
        foreach($matched_notifications as $key=>$notification)
        {
            $type_notification = DB::table('notification_type')
            ->where('id',$notification->type)->first();
            if($type_notification);
            $matched_notifications[$key]->name_type = $type_notification->type;
        }
        
        return $matched_notifications;
    }
    
static public function sendMessTwilio($sms_number,$message)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $res = $client->messages
        ->create($sms_number, // to
                 [
                     "body" => $message,
                     "messagingServiceSid" => $twilio_number = getenv("TWILIO_SMS_SERVICE_ID")
                 ]
        );
    }




    function TemplateManagementView() {


        $dataTemplate = NotificationController::getTemplate();
        return view('Backend.template.template-management')
        ->with('dataTemplate', $dataTemplate);
    }


    function AddNewTemplateView() {

        $dataRegion = NotificationController::getRegion();
        $dataArea = NotificationController::getArea();
        $dataIndustry = NotificationController::getIndustry();
        $dataStore = NotificationController::getStore();


        return view('Backend.template.add-new-template-view')
        ->with('dataRegion', $dataRegion)
        ->with('dataArea', $dataArea)
        ->with('dataIndustry', $dataIndustry)
        ->with('dataStore', $dataStore);
    }

    function UpdateTemplateView($template_id) {


        $data = DB::table('template')
        ->where(['id' => $template_id])
        ->get(
            array(
                'id',
                'template_name',
                'template_title',
                'template_content',
                'region_id',
                'area_id',
                'industry_id',
                'store_id',
                'created_at',
                )
        );
        // dump($data[0]);
   


        $dataRegion = NotificationController::getRegion();
        $dataArea = NotificationController::getArea();
        $dataIndustry = NotificationController::getIndustry();
        $dataStore = NotificationController::getStore();




        return view('Backend.template.update-template-view')
        ->with('dataTemplate', $data[0])
        ->with('dataRegion', $dataRegion)
        ->with('dataArea', $dataArea)
        ->with('dataIndustry', $dataIndustry)
        ->with('dataStore', $dataStore);
    }

    public function reqAddNewTemplate(Request $request)
    {
       $result = DB::table('template')
       ->insert([
        'created_at'=>now(),
        'id'=>Str::uuid()->toString(),
        'template_name'=>$request->template_name,
        'template_title'=>$request->template_title,
        'template_content'=>$request->template_content,
        'region_id'=>$request->region_id,
        'area_id'=>$request->area_id,
        'industry_id'=>$request->industry_id,
        'store_id'=>$request->store_id,
       ]);
       return ['result'=>$result];
    }
    public function reqUpdateNewTemplate(Request $request)
    {
       $result = DB::table('template')
       ->where('id', $request->id)
       ->update([
        'created_at'=>now(),
        'id'=>Str::uuid()->toString(),
        'template_name'=>$request->template_name,
        'template_title'=>$request->template_title,
        'template_content'=>$request->template_content,
        'region_id'=>$request->region_id,
        'area_id'=>$request->area_id,
        'industry_id'=>$request->industry_id,
        'store_id'=>$request->store_id,
       ]);
       return ['result'=>$result];
    }

    


    // function AddNewTemplateView() {


    //     $dataRegion = NotificationController::getRegion();
    //     $dataArea = NotificationController::getArea();
    //     $dataIndustry = NotificationController::getIndustry();
    //     $dataStore = NotificationController::getStore();




    //     return view('Backend.template.add-new-template-view')
    //     ->with('dataRegion', $dataRegion)
    //     ->with('dataArea', $dataArea)
    //     ->with('dataIndustry', $dataIndustry)
    //     ->with('dataStore', $dataStore);
    // }




    function GetTemplateForSendMail(Request $request) {
        $data = DB::table('template')
        ->where(['id' => $request->template_id])
        ->get(
            array(
                'id',
                'template_name',
                'template_title',
                'template_content',
                'region_id',
                'area_id',
                'industry_id',
                'store_id',
                'created_at',
                )
        );


        return $data[0];
    }


    function getTemplate() {
        $data = DB::table('template')
        ->orderBy('id', 'desc')
        ->get(
            array(
                'id',
                'template_name',
                'template_title',
                'template_content',
                'region_id',
                'area_id',
                'industry_id',
                'store_id',
                'created_at',
                )
        );


        return $data;
    }

    function getRegion() {
        $data = DB::table('static_region')
        ->get(
            array(
                'id',
                'region_name'
                )
        );

        return $data;
    }

    function getArea() {
        $data = DB::table('static_area')
        ->get(
            array(
                'id',
                'area_name'
                )
        );

        return $data;
    }

    function getIndustry() {
        $data = DB::table('static_industry')
        ->get(
            array(
                'id',
                'industry_name'
                )
        );

        return $data;
    }

    function getStore() {
        $data = DB::table('static_store')
        ->get(
            array(
                'id',
                'store_name'
                )
        );

        return $data;
    }


}
