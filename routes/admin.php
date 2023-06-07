<?php

namespace App\Http\Controllers\Admins;

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
Route::post('login', [AuthController::class, 'login']);
Route::post('forget_password', [ForgotPasswordController::class, 'forgetPassword']);
Route::post('reset_password', [ForgotPasswordController::class, 'resetPassword']);

Route::group(['middleware' => ['auth:admin']], function () {

    Route::post('admins/unlock/{id}', [AdminController::class, 'unlock']);
    Route::resource('/admins', AdminController::class);
    Route::post('update_forget_password', [ForgotPasswordController::class, 'updateForgetPassword']);
    Route::get('profile', [ProfileController::class, 'getAdminInfo']);
    Route::post('update_password', [ProfileController::class, 'updatePassword']);
    Route::post('update_profile/{admin}', [ProfileController::class, 'updateProfile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('managers/unlock/{manager}', [ManagerController::class, 'unlock']);
    Route::post('managers/{manager}/change-status', [ManagerController::class,'changeStatus']);
    Route::resource('managers', ManagerController::class)->parameter('', 'branch_id');
    Route::get('branch_managers_of_company_dont_have_branches/{company_id}', [ManagerController::class,'getBranchManagersOfCompanyDontHaveBranches']);
    Route::get('owners_doesnt_have_company', [ManagerController::class,'getOwnersDoesntHaveCompany']);
});
