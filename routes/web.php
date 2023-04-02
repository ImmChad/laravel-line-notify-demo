<?php

// use App\Http\Controllers\Admin\NotificationController;

use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\NotificationDraftController;
use App\Http\Controllers\Admin\NotificationTemplateController;
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


Route::get('/login', [UserController::class, 'viewLoginUser']);

Route::get('/logout-user', [UserController::class, 'logoutUser']);
Route::get('/login-user', [UserController::class, 'viewLoginUser']);
Route::get('/signup-user', [UserController::class, 'viewSignupUser']);
Route::post('/login-user', [UserController::class, 'loginUser']);
Route::post('/signup-user', [UserController::class, 'signupUser']);
Route::get('/user/connect-sms', [UserController::class, 'viewConnectSMS']);
Route::post('/user/verify-SMS', [UserController::class, 'verifySMS']);


Route::group(['prefix' => '/user', 'middleware' => 'checkUserLogin'], function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('/view-user', [UserController::class, 'viewUser']);
    Route::get('notification/{id}/detail', [UserController::class, 'detailNotification']);
    Route::get('notify/list', [UserController::class, 'viewAllAnnounceUser']);
    Route::get('setting-notification', [UserController::class, 'viewSettingNotification'])->name('setting-notification-user');
});
Route::get('/', [UserController::class, 'index'])->middleware("checkUserLogin");

// Connect Line + Callback Line
Route::get('line/login', [UserController::class, 'redirectToLine'])->name('login.line');
Route::get('line/login/callback', [UserController::class, 'handleLineCallback'])->name('login.line.callback');

// Connect Gmail + Callback Gmail
Route::get('authorized/google', [ConnectGmailController::class, 'redirectToGoogle']);
Route::get('authorized/google/callback', [ConnectGmailController::class, 'handleGoogleCallback']);


// admin
Route::get('/admin', [NotificationController::class, 'loginAdmin']);
Route::post('/admin/login', [NotificationController::class, 'handleSubmitLogin']);
Route::group(array('prefix' => '/admin', 'middleware' => 'checkAdminLogin'), function () {

    Route::get('/log-out', [NotificationController::class, 'reqLogout']);

    // 1. link register line list
    Route::get('/register-line-list',
        [NotificationController::class, 'registerLineList'])
        ->name('admin.notification.register-line-list');

    // 2. link notification list
    Route::get('/notification-list',
        [NotificationController::class, 'notificationList'])
        ->name('admin.notification.notification-list');

    Route::get('/notification/{id}/detail',
        [NotificationController::class, 'detailNotification'])
        ->name('admin.notification.detailNotification');

    Route::get('/notification/delete/{notificationId}',
        [NotificationController::class, 'deleteNotification'])
        ->name('admin.notification.deleteNotification');

    Route::post('/search-notification',
        [NotificationController::class, 'searchNotification'])
        ->name('admin.notification.searchNotification');

    Route::get('/send-notification-view/{notificationType}/{notificationSender?}/{notificationTemplate?}',
        [NotificationController::class, 'showSendNotificationView'])
        ->name('admin.notification.showSendNotificationView');

    Route::post('/get-area-from-region-id',
        [NotificationController::class, 'getAreaFromRegionId'])
        ->name('admin.notification.getAreaFromRegionId');

    Route::get('/update-notification-view/{notificationId}',
        [NotificationController::class, 'showContentUpdateNotificationToView'])
        ->name('admin.notification.showContentUpdateNotificationToView');

    Route::post('/update-mess',
        [NotificationController::class, 'sendUpdateForListUser'])
        ->name('admin.notification.sendUpdateForListUser');

    // 3. template
    Route::get('/template-management',
        [NotificationTemplateController::class, 'showTemplateManagementView'])
        ->name('admin.notification.template-management');

    Route::get('/add-new-template-view',
        [NotificationTemplateController::class, 'showAddNewTemplateView'])
        ->name('admin.notification.template-management.add_get');

    Route::post('/add-template',
        [NotificationTemplateController::class, 'reqAddNewTemplate'])
        ->name('admin.notification.reqAddNewTemplate');

    Route::get('/update-template-view/{templateId}',
        [NotificationTemplateController::class, 'showUpdateTemplateView'])
        ->name('admin.notification.template-management');

    Route::post('/update-template',
        [NotificationTemplateController::class, 'reqUpdateNewTemplate'])
        ->name('admin.notification.reqUpdateNewTemplate');

    Route::post('/get-template-for-send-mail',
        [NotificationTemplateController::class, 'getTemplateForSendMail'])
        ->name('admin.notification.getTemplateForSendMail');


    Route::get('/update-notification-draft/{notificationDraftId}/{notificationSender?}/{notificationTemplate?}',
        [NotificationDraftController::class, 'renderUpdateNotificationDraft'])
        ->name('admin.notification.renderUpdateNotificationDraft');

    Route::post('/update-notification-draft',
        [NotificationDraftController::class, 'updateNotificationDraft'])
        ->name('admin.notification.updateNotificationDraft');

    Route::post('/cancel-notification-draft',
        [NotificationDraftController::class, 'cancelNotificationDraft'])
        ->name('admin.notification.cancelNotificationDraft');

    Route::post('/send-mess',
        [NotificationDraftController::class, 'saveNotificationDraft'])
        ->name('admin.notification.saveNotificationDraft');


    // 4. Cronjob
    Route::post('/send-notification',
        [NotificationController::class, 'sendMessForListUser'])
        ->name('admin.notification.sendMessForListUser');
});









