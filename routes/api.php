<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChamberController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\EventController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register',[UserController::class , 'register'])->name('register');
Route::post('login',[UserController::class , 'login'])->name('login');
Route::post('forgotpassword',[UserController::class , 'forgotpassword'])->name('forgotpassword');
Route::post('updatepassword',[UserController::class , 'updatePassword'])->name('updatepassword');
Route::post('resetpassword',[UserController::class , 'resetPassword'])->name('resetpassword');

Route::post('update',[UserController::class , 'profileUpdate'])->name('update');

// Chamber Routes

Route::post('createChamber',[ChamberController::class , 'create'])->name('createChamber');
Route::post('showChamber',[ChamberController::class , 'show'])->name('showChamber');


// News Routes
Route::post('addNews',[NewsController::class , 'store'])->name('addNews');
Route::get('showNews',[NewsController::class , 'show'])->name('showNews');
Route::get('latestNews',[NewsController::class , 'latestNews'])->name('latestNews');


// Business Routes
Route::post('addBusiness',[BusinessController::class , 'store'])->name('addBusiness');
Route::post('showBusiness',[BusinessController::class , 'show'])->name('showBusiness');

// Community Routes
Route::post('addMessage',[CommunityController::class , 'addMessage'])->name('addMessage');
Route::get('showMessages',[CommunityController::class , 'showMessages'])->name('showMessages');


// Events
Route::get('showEvents',[EventController::class , 'showEvents'])->name('showEvents');
