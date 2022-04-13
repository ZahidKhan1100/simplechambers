<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChamberController;

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
