<?php

use App\Http\Controllers\Admin\AdminController;
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

Route::get('/user', [UserController::class, 'viewUser']);
Route::get('/logout-user', [UserController::class, 'logoutUser']);


// Route::get('/login/line', [UserController::class, 'redirectToLine']);
// Route::get('/login/line/callback', [UserController::class, 'handleGoogleCallback']);

// Login Line
Route::get('line/login', 'UserController@redirectToLine')->name('login.line');
// Callback url
Route::get('line/login/callback', [UserController::class, 'handleLineCallback'])->name('login.line.callback');




Route::get('/admin', [AdminController::class, 'index']);
Route::post('/admin/send-mess', [AdminController::class, 'sendMessForListUser']);






