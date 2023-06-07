<?php

use Illuminate\Support\Facades\Route;
use App\Modules\BanksAccounts\Http\Controllers\Manager\BankAccountController;
use App\Modules\BanksAccounts\Http\Controllers\Manager\Branch\BankAccountController as BranchBankAccountController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Admin API!
|
*/

Route::apiResource('bank_accounts', BankAccountController::class)->middleware('auth:manager');
Route::apiResource('branch/bank_accounts', BranchBankAccountController::class)->middleware('auth:manager');


