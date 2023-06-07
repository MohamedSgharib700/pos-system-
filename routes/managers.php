<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Areas\Http\Controllers\Manager\AreaController;
use App\Modules\Banks\Http\Controllers\Manager\BankController;
use App\Modules\Cities\Http\Controllers\Manager\CityController;
use App\Modules\Branch\Http\Controllers\Manager\BrachController;

/* Managers APIs */

Route::post('register', 'AuthController@register')->name('manager.store');
Route::post('login', 'AuthController@login')->name('manager.login')->middleware('check.isActive.manager');

Route::post('forget_password', 'ForgotPasswordController@forgetPassword');
Route::post('reset_password', 'ForgotPasswordController@resetPassword');

Route::group(['middleware' => 'auth:manager'], function () {
    Route::get('logout', 'AuthController@logout')->name('manager.logout');

    Route::post('update_forget_password', 'ForgotPasswordController@updateForgetPassword');

    Route::resource('profile', 'ProfileController')->only('index', 'update');

    Route::post('change_password', 'ProfileController@changePassword')->name('manager.change_password');

    Route::post('managers/{manager}/change-status', 'ManagerController@changeStatus');

    Route::post('managers/unlock/{manager}', 'ManagerController@unlock');
    Route::resource('managers', 'ManagerController');
    Route::get('branch_managers_dont_have_branch', 'ManagerController@getBranchManagersDontHaveBranches');

    Route::resource('pos-users', 'PosUserController');
    Route::post('pos-users/unlock/{posUser}', 'PosUserController@unlock');
});

Route::get('branches', [BrachController::class, 'index']);
Route::get('cities', [CityController::class, 'index']);
Route::get('areas', [AreaController::class, 'index']);
Route::get('banks', [BankController::class, 'index']);
