<?php

// use App\Http\Controllers\Admin\NotificationController;

use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\User\ConnectGmailController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [UserController::class, 'index']);
Route::get('/login', [UserController::class, 'index']);

Route::get('/logout-user', [UserController::class, 'logoutUser']);
Route::get('/login-user', [UserController::class, 'viewLoginUser']);
Route::get('/signup-user', [UserController::class, 'viewSignupUser']);
Route::post('/login-user', [UserController::class, 'loginUser']);
Route::post('/signup-user', [UserController::class, 'signupUser']);
Route::get('/user/connect-sms', [UserController::class, 'viewConnectSMS']);
Route::post('/user/verify-SMS', [UserController::class, 'verifySMS']);


Route::group(['prefix'=>'/user','middleware'=>'checkUserLogin'],function(){
    Route::get('', [UserController::class, 'index']);
    Route::get('/view-user', [UserController::class, 'viewUser']);
    Route::get('notification/{id}/detail', [UserController::class, 'detailNotification']);
    Route::get('notify/list', [UserController::class, 'viewAllAnnounceUser']);
    Route::get('setting-notification', [UserController::class, 'viewSettingNotification']);
});


// Connect Line + Callback Line
Route::get('line/login', [UserController::class, 'redirectToLine'])->name('login.line');
Route::get('line/login/callback', [UserController::class, 'handleLineCallback'])->name('login.line.callback');

// Connect Gmail + Callback Gmail
Route::get('authorized/google', [ConnectGmailController::class, 'redirectToGoogle']);
Route::get('authorized/google/callback', [ConnectGmailController::class, 'handleGoogleCallback']);

// Test Send Mess Twillio
Route::post('test/send-mess-twilio', [NotificationController::class, 'sendMessTwilio']);

// admin
Route::get('/admin', [NotificationController::class, 'loginAdmin']);
Route::post('/admin/login', [NotificationController::class, 'handleSubmitLogin']);
Route::group(array('prefix' => '/admin','middleware'=>'checkAdminLogin'), function() {
    Route::get('/log-out', [NotificationController::class, 'reqLogout']);

    // link register line list
    Route::get('/register-line-list', [NotificationController::class, 'registerLineList'])->name('register-line-list');

    // link notification list
    Route::post('/search-notification', [NotificationController::class, 'searchNotification']);

    Route::get('/notification-list', [NotificationController::class, 'notificationList'])->name('notification-list');
    Route::get('/notification/{id}/detail', [NotificationController::class, 'detailNotification']);
    Route::get('/notification/delete/{notificationId}', [NotificationController::class, 'deleteNotification']);

//    Route::get('/send-notification-view/{notification_type}', [NotificationController::class, 'showSendNotificationView'])->name('notification-list');
    Route::post('/send-mess', [NotificationController::class, 'sendMessForListUser']);
    Route::post('/get-template-for-send-mail', [NotificationController::class, 'getTemplateForSendMail'])->name('notification-list');

    Route::get('/update-notification-view/{notificationId}', [NotificationController::class, 'showContentUpdateNotificationToView'])->name('notification-list');
    Route::post('/update-mess', [NotificationController::class, 'sendUpdateForListUser']);

    // link template list
    Route::get('/template-management', [NotificationController::class, 'showTemplateManagementView'])->name('template-management');

//    Route::get('/add-new-template-view', [NotificationController::class, 'showAddNewTemplateView'])->name('template-management.add_get');
    Route::post('/add-template', [NotificationController::class, 'reqAddNewTemplate']);


    Route::get('/update-template-view/{templateId}', [NotificationController::class, 'showUpdateTemplateView'])->name('template-management');
    Route::post('/update-template', [NotificationController::class, 'reqUpdateNewTemplate']);

    Route::get('/add-new-template-view', function ()
    {
        return view("Backend.template.tmp-add-new-template-view");
    })->name('template-management.add_get');
    Route::get('/send-notification-view/3', function ()
    {
        return view("Backend.tmp-send-notification-view-3");
    })->name('notification-list');
});









