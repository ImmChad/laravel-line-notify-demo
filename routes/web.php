<?php

// use App\Http\Controllers\Admin\NotificationController;

use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\User\ConnectGmailController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Session;
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
    Route::post('get-announce-content', [UserController::class, 'getAnnounceContentRead']);
    Route::get('notify/list', [UserController::class, 'viewAllAnnounceUser']);
    Route::get('setting-notification', [UserController::class, 'viewSettingNotification']);
    Route::post('/login-SMS', [UserController::class, 'loginSMS']);
    Route::get('/login-sms', [UserController::class, 'viewLoginSMS']);

    Route::post('/req-connect-SMS', [UserController::class, 'connectSMS']);

});


// Login Line
Route::get('line/login', [UserController::class, 'redirectToLine'])->name('login.line');
// Callback url
Route::get('line/login/callback', [UserController::class, 'handleLineCallback'])->name('login.line.callback');

// Login Gmail
Route::get('authorized/google', [ConnectGmailController::class, 'redirectToGoogle']);
// Callback Gmail
Route::get('authorized/google/callback', [ConnectGmailController::class, 'handleGoogleCallback']);

Route::post('test/send-mess-twilio', [NotificationController::class, 'sendMessTwilio']);

 // admin 
Route::get('/admin', [NotificationController::class, 'loginAdmin']);
Route::post('/admin/login', [NotificationController::class, 'handleSubmitLogin']);
Route::group(array('prefix' => '/admin','middleware'=>'checkAdminLogin'), function() {
    // Route::get('/', [NotificationController::class, 'NavigationView']);
    // Route::get('/line-user-view', [AdminController::class, 'index']);
    // Route::get('/announce-view', [AdminController::class, 'announceView']);
    // Route::get('/send-message-view', [AdminController::class, 'sendMessView']);
    Route::get('/notification/{id}/detail', [NotificationController::class, 'detailNotification']);

    Route::post('/send-mess', [NotificationController::class, 'sendMessForListUser']);
    // Route::post('/get-announce-content', [AdminController::class, 'getAnnounceContent']);
    Route::get('/log-out', [NotificationController::class, 'reqLogout']);

    Route::get('/register-line-list', [NotificationController::class, 'RegisterLineList'])->name('register-line-list');
    Route::get('/notification-list', [NotificationController::class, 'NotificationList'])->name('notification-list');
    Route::get('/send-notification-view/{notification_type}', [NotificationController::class, 'SendNotificationView'])->name('notification-list');
    Route::post('/add-template', [NotificationController::class, 'reqAddNewTemplate']);
    Route::post('/update-template', [NotificationController::class, 'reqUpdateNewTemplate']);

    Route::post('/search-notification', [NotificationController::class, 'searchNotification']);
    Route::post('/get-template-for-send-mail', [NotificationController::class, 'GetTemplateForSendMail'])->name('notification-list');


    Route::get('/template-management', [NotificationController::class, 'TemplateManagementView'])->name('template-management');
    Route::get('/add-new-template-view', [NotificationController::class, 'AddNewTemplateView'])->name('template-management');
    Route::get('/update-template-view/{template_id}', [NotificationController::class, 'UpdateTemplateView'])->name('template-management');


    // Route::get('/notification-list', [NotificationController::class, 'NotificationList'])->name('notification-list');


});

//Language Change
Route::get('lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'de', 'es','fr','pt', 'cn', 'ae'])) {
        abort(400);
    }   
    Session()->put('locale', $locale);
    Session::get('locale');
    return redirect()->back();
})->name('lang');







