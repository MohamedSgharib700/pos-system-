<?php

namespace App\Http\Controllers\Pos_users;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->middleware('check.isActive.posUser');
Route::post('forget_password', [ForgotPasswordController::class, 'forgetPassword']);
Route::post('reset_password', [ForgotPasswordController::class, 'resetPassword']);
Route::group(['middleware' => ['auth:pos']], function () {
    Route::post('update_forget_password', [ForgotPasswordController::class, 'updateForgetPassword']);
    Route::get('profile', [ProfileController::class, 'getInfo']);
    Route::post('update_password', [ProfileController::class, 'updatePassword']);
    Route::post('update_profile/{pos_user}', [ProfileController::class, 'updateProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
});
